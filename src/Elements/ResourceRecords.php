<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;
use Illuminate\Http\Request;

class ResourceRecords extends Element
{
    public $component = 'ResourceRecords';
    public $import = true;

    public $attributes = [
        'class' => []
    ];

    public function __construct($resource, $records)
    {
        $request = request();
        $fields = $resource->resolveFields();

        $this->attributes['fields'] = $fields;
        $this->attributes['actions'] = $resource->actionsForRoute('table');
        $this->attributes['slug'] = $resource->slug();
        $this->attributes['filters'] = $request->all('search', 'order', 'sortBy');

        $this->attributes['records'] = [
            'links' => $records->links(),
            'data' => $records->items()->map(function($item) use($resource) {
                return [
                    'data' => $item,
                    'fields' => $resource->newInstance()->bindRecord($item)->renderFields()
                ];
            })
        ];
    }
}