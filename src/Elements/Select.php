<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;
use PixelBoii\Vague\Vague;

class Select extends Element
{
    public $component = 'Select';
    public $import = true;

    public $attributes = [
        'options' => []
    ];

    public function __construct($options)
    {
        $this->attributes['options'] = array_map(function($option) {
            return [
                'element' => $option
            ];
        }, $options);

        $this->id = Vague::registerElement($this);
    }
}