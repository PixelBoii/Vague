<?php

namespace PixelBoii\Vague\Actions;

use Str;
use Exception;

class Method extends Action
{
    public function __construct($method, $id = null, $name = null)
    {
        if (is_callable($method) && is_null($id)) {
            throw new Exception("ID must be supplied if you're directly passing a callable function");
        }

        // ID will always be set if it's callable
        if (is_callable($method)) {
            $this->id = $id;
        } else {
            $this->id = $method[1];
        }

        $this->method = $method;
        $this->name = $name ?? Str::title($this->id);

        $this->primary();
    }
}