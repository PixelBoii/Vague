<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class Card extends Element
{
    public $tag = 'div';

    public function getClass()
    {
        return implode(' ', [
            ...$this->attributes['class'] ?? [],
            'bg-white',
            'rounded-md',
            'shadow',
            'p-4'
        ]);
    }
}