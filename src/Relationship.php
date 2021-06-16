<?php

namespace PixelBoii\Vague;

use PixelBoii\Vague\Resource;
use PixelBoii\Vague\Element;

use Illuminate\Support\Str;

use JsonSerializable;
use ReflectionObject;
use ReflectionProperty;
use Exception;

class Relationship implements JsonSerializable
{
    public $target;
    public $resource;

    public function query()
    {
        $relationship = $this->target()::slug();

        if (!method_exists($this->resource->model(), $relationship)) {
            $this->resource->model()->resolveRelationUsing($relationship, fn($model) => $this->buildRelationship($model));
        }

        return $this->resource->record->$relationship();
    }

    public function get($record)
    {
        return $this->query($record)->get();
    }

    public function target()
    {
        return new $this->target();
    }

    public function __call($name, $args)
    {
        if (!method_exists($this->target(), $name)) {
            throw new Exception('Method ' . $name . ' does not exist on resource ' . $this->target);
        }

        return Element::relationship($this, $name, ...$args);
    }

    public function table()
    {
        $request = request();

        $request->validate([
            'sortBy' => ['string'],
            'order' => ['in:DESC,ASC'],
            'search' => ['string']
        ]);

        $query = $this->query();
        $fields = $this->target()->resolveFields($this->resource->record);

        $sortBy = $request->get('sortBy') ?? 'created_at';
        $search = $request->get('search') ?? '';
        $sortOrder = $request->get('order') ?? 'DESC';

        $query->orderBy($sortBy, $sortOrder)->where(fn($query) => $this->target()->search($query, $search));

        return Element::div([
            Element::subText($this->target()->name()),
            Element::resourceRecords($this->target(), $query->paginate())
        ]);
    }

    public function jsonSerialize()
    {
        $properties = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);
        $json = [];

        foreach ($properties as $property) {
            $name = $property->name;
            $json[$name] = $this->$name;
        }

        $json['name'] = class_basename($this);
        $json['target'] = $this->target();

        return $json;
    }

    public function bindResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    public function slug()
    {
        return (string) Str::of($this->target()->slug())->studly()->singular();
    }

    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }
}