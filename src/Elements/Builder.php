<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class Builder extends Element
{
    public $import = true;

    public function __construct($component, $attributes = [], $content = [])
    {
        $this->component = $component;
        $this->attributes = $attributes;
        $this->content = $content;
    }
}