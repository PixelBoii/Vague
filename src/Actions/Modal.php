<?php

namespace PixelBoii\Vague\Actions;

use PixelBoii\Vague\Element;

class Modal
{
    protected $action;
    public $body;

    public function __construct($action)
    {
        $this->action = $action;
    }

    public function body($body)
    {
        $this->body = Element::div($body);
    }
}