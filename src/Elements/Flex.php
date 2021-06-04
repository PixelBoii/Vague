<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class Flex extends Div
{
    public function getClass()
    {
        return implode(' ', [
            ...$this->attributes['class'] ?? [],
            'flex'
        ]);
    }
}