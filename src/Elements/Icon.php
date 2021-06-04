<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class Icon extends Image
{
    public function getClass()
    {
        return implode(' ', [
            ...$this->attributes['class'] ?? [],
            'h-7',
            'w-7',
            'rounded-full'
        ]);
    }
}