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

    public function __construct($resource, $record)
    {
        $this->attributes['record'] = $record;
        $this->attributes['fields'] = array_filter($resource->resolveFields($record), fn($field) => $field->displayOnForm);
        $this->attributes['actions'] = $resource->actionsForRoute('recordForm');
    }
}