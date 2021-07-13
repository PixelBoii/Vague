<?php

namespace PixelBoii\Vague;

use Illuminate\Support\Str;

class ResourceFields
{
    public $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function __call($name, $arguments)
    {
        $field = 'PixelBoii\\Vague\\Fields\\' . Str::studly($name);

        return new $field($this->resource, ...$arguments);
    }
}