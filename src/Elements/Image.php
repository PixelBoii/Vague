<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class Image extends Element
{
    public $tag = 'img';

    public $attributes = [
        'alt' => '',
        'class' => []
    ];

    public function __construct($icon)
    {
        $this->setAttribute('src', $icon);
    }
}