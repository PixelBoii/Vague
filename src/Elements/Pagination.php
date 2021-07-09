<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class Pagination extends Element
{
    public $component = 'Pagination';
    public $import = true;

    public function __construct($links)
    {
        $this->attributes['links'] = $links;
    }
}