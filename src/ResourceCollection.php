<?php

namespace PixelBoii\Vague;

use PixelBoii\Vague\Element;

class ResourceCollection
{
    public $query;
    public $resource;

    public function __construct($query, $resource)
    {
        $this->query = $query;
        $this->resource = $resource;
    }

    public function table()
    {
        $request = request();

        $request->validate([
            'sortBy' => ['string'],
            'order' => ['in:DESC,ASC'],
            'search' => ['string']
        ]);

        $sortBy = $request->get('sortBy') ?? 'created_at';
        $search = $request->get('search') ?? '';
        $sortOrder = $request->get('order') ?? 'DESC';

        $this->query->orderBy($sortBy, $sortOrder)->where(fn($query) => $this->resource->search($query, $search));

        return Element::resourceRecords($this->resource, $this->query->paginate());
    }

    public function __call($name, $args)
    {
        $limit = $args[0] ?? 4;

        return Element::div(
            $this->query->limit($limit)->get()->map(function($record) use($name) {
                if (isset($record)) {
                    return $this->resource->bindRecord($record)->$name()->meta([
                        'record' => $record
                    ]);
                } else {
                    return $this->resource->notFound();
                }
            })->toArray()
        );
    }
}