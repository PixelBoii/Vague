<?php

namespace PixelBoii\Vague;

class ResourceFields
{
    public $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function __call($name, $arguments)
    {
        $field = 'PixelBoii\\Vague\\Fields\\' . $name;

        return new $field($this->resource, ...$arguments);
    }
}