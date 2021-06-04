<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class Separator extends Element
{
    public $tag = 'div';

    public function getClass()
    {
        return implode(' ', [
            'bg-gray-200',
            'h-px',
            'w-full'
        ]);
    }
}