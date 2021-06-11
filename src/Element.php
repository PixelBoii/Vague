<?php

namespace PixelBoii\Vague;

use Illuminate\Support\Str;
use JsonSerializable;

class Element implements JsonSerializable
{
    public $content = [];

    public $attributes = [
        'class' => []
    ];

    public $meta = [];

    public function __construct($content = [])
    {
        if ($content instanceof Element) {
            $content = [$content];
        }

        $this->content = $content;
    }

    public function jsonSerialize()
    {
        return [
            'attributes' => $this->getAttributes(),
            'content' => $this->render(),
            'tag' => $this->tag
        ];
    }

    public function render()
    {
        return $this->content;
    }

    public function getAttributes()
    {
        $attributes = $this->attributes;

        foreach (array_keys($attributes) as $attribute_key) {
            $method_guess = 'get' . Str::ucfirst($attribute_key);

            if (method_exists($this, $method_guess)) {
                $attributes[$attribute_key] = $this->$method_guess();
            }
        }

        return $attributes;
    }

    public function getClass()
    {
        return implode(' ', $this->attributes['class']);
    }

    public function setAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;

        return $this;
    }

    public function map(Callable $fn)
    {
        $this->content = array_map(fn($el) => $fn($el), $this->content);

        return $this;
    }

    public function template($element)
    {
        $element->content = $this->content;

        return $element;
    }

    public function class($class)
    {
        if (gettype($class) == 'string') {
            $class = explode(' ', $class);
        }

        $this->attributes['class'] = array_merge($this->attributes['class'], $class);
        return $this;
    }

    public function setClass($class)
    {
        $this->attributes['class'] = [];

        return $this->class($class);
    }

    public function meta($meta)
    {
        foreach ($meta as $key => $value) {
            $this->meta[$key] = $value;
        }

        return $this;
    }

    /**
     * Find element if no other static method matches
    */
    public static function __callStatic($method, $args)
    {
        $element = __NAMESPACE__ . '\\Elements\\' . Str::studly($method);

        return new $element(...$args);
    }
}