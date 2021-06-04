<?php

namespace PixelBoii\Vague;

class ResourceFields
{
    public function __construct()
    {
        //
    }

    public function __call($name, $arguments)
    {
        $field = 'PixelBoii\\Vague\\Fields\\' . $name;

        return new $field(...$arguments);
    }
}