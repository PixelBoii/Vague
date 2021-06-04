<?php

namespace PixelBoii\Vague;

class ResourceActions
{
    public function __call($name, $arguments)
    {
        $field = 'PixelBoii\\Vague\\Actions\\' . $name;

        return new $field(...$arguments);
    }
}