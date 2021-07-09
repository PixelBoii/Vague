<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class Link extends Element
{
    public $component = 'inertia-link';

    public $attributes = [
        'href' => ''
    ];

    public function __construct($content, $link)
    {
        $this->attributes['href'] = $link;

        parent::__construct($content);
    }
}