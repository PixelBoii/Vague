<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class SubText extends Text
{
    public $tag = 'p';

    public $attributes = [
        'class' => ['text-gray-400', 'font-medium', 'text-sm']
    ];
}