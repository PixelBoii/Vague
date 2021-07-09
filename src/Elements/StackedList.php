<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class StackedList extends Element
{
    public $component = 'StackedList';
    public $import = true;

    public $attributes = [
        'class' => []
    ];

    public function __construct($elements)
    {
        $this->attributes['elements'] = $elements;
    }

    public function elements()
    {
        return $this->attributes['elements'];
    }
}