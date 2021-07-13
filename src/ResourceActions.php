<?php

namespace PixelBoii\Vague;

use Illuminate\Support\Str;

class ResourceActions
{
    public function __call($name, $arguments)
    {
        $action = 'PixelBoii\\Vague\\Actions\\' . Str::studly($name);

        return new $action(...$arguments);
    }
}