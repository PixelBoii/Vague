<?php

namespace PixelBoii\Vague;

use PixelBoii\Vague\Resource;
use PixelBoii\Vague\Element;
use PixelBoii\Vague\ResourceCollection;

use Illuminate\Support\Str;

use JsonSerializable;
use ReflectionObject;
use ReflectionProperty;

class Relationship implements JsonSerializable
{
    public $target;
    public $resource;
    public $link = true;

    public function query()
    {
        $relationship = $this->target()::slug();

        if (!method_exists($this->resource->model(), $relationship)) {
            $this->resource->model()->resolveRelationUsing($relationship, fn($model) => $this->buildRelationship($model));
        }

        return $this->resource->record->$relationship();
    }

    public function link()
    {
        $this->link = true;

        return $this;
    }

    public function dontLink()
    {
        $this->link = false;

        return $this;
    }

    public function target()
    {
        return new $this->target();
    }

    public function first()
    {
        return $this->target()->bindRecord($this->query()->first());
    }

    public function get()
    {
        return new ResourceCollection($this->query(), $this->target());
    }

    public function table()
    {
        return $this->get()->table();
    }

    public function stackedList(...$args)
    {
        return $this->get()->stackedList(...$args);
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

    public function __call($name, $args)
    {
        $baseLink = '/' . config('vague.prefix') . '/resource/' . $this->target()->slug() . '/';

        if ($this->type == 'single') {
            $resource = $this->first();

            if (isset($resource->record)) {
                return $this->link ? Element::link($resource->$name(...$args), $baseLink . $resource->record->id) : $resource->$name(...$args);
            } else {
                return $this->target()->notFound();
            }
        } else {
            return $this->get()->$name(...$args)->map(fn($el) => $this->link && isset($el->meta['record']) ? Element::link($el, $baseLink . $el->meta['record']->id) : $el);
        }
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