<?php

namespace PixelBoii\Vague\Fields;

class SelectItem
{
    public $name;
    public $alias;

    public function __construct($resource, $name)
    {
        $this->name = $name;
    }

    public function alias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }
}