<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class RecordForm extends Element
{
    public $tag = 'RecordForm';

    public $attributes = [
        'class' => [],
        'actions' => []
    ];

    public function __construct($resource)
    {
        $this->attributes['record'] = $resource->record;
        $this->attributes['fields'] = array_values(array_filter($resource->renderFields(), fn($field) => $field['displayOnForm']));
        $this->attributes['actions'] = $resource->actionsForRoute('recordForm');
    }
}