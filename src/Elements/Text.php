<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class Text extends Element
{
    public $tag = 'p';

    public $attributes = [
        'class' => ['text-gray-700', 'font-medium']
    ];
}