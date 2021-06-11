<?php

namespace PixelBoii\Vague;

use PixelBoii\Vague\Resource;
use PixelBoii\Vague\Element;

use Illuminate\Support\Str;

class Relationship
{
    public $target;

    public function query($record)
    {
        $relationship = $this->target()::slug();

        if (!method_exists($record, $relationship)) {
            $record->resolveRelationUsing($relationship, fn($model) => $this->buildRelationship($model));
        }

        return $record->$relationship();
    }

    public function get($record)
    {
        return $this->query($record)->get();
    }

    public function target()
    {
        return new $this->target();
    }

    public function summaryForItem($item, $fn = null)
    {
        $summary = $this->target()->summary($item);

        if (isset($fn)) {
            return $fn($summary, $this->target(), $item);
        } else {
            return $summary;
        }
    }

    public function summary(...$args)
    {
        return Element::relationship($this, ...$args);
    }

    public function table($record)
    {
        $request = request();

        $request->validate([
            'sortBy' => ['string'],
            'order' => ['in:DESC,ASC'],
            'search' => ['string']
        ]);

        $query = $this->query($record);
        $fields = $this->target()->resolveFields($record);

        $sortBy = $request->get('sortBy') ?? 'created_at';
        $search = $request->get('search') ?? '';
        $sortOrder = $request->get('order') ?? 'DESC';

        $query->orderBy($sortBy, $sortOrder)->where(fn($query) => $this->target()->search($query, $search));

        return Element::div([
            Element::subText($this->target()->name()),
            Element::resourceRecords($this->target(), $query->paginate())
        ]);
    }

    public function slug()
    {
        return (string) Str::of($this->target()->slug())->studly()->singular();
    }

    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Find relationship if no other static method matches
    */
    public static function __callStatic($method, $args)
    {
        $element = __NAMESPACE__ . '\\Relationships\\' . Str::studly($method);

        return new $element(...$args);
    }
}