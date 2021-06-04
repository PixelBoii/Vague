<?php

namespace PixelBoii\Vague\Fields;

use Illuminate\Support\Str;

class Field
{
    public $displayOnForm = true;
    public $columnSpan = 6;

    public $column;
    public $name;

    public function __construct($name, $column = null)
    {
        if (is_null($column)) {
            $this->column = Str::snake(Str::lower($name));
        }

        $this->name = Str::of($name)->replace('_', ' ')->ucFirst();
    }

    public static function make(...$arguments): Field
    {
        return new static(...$arguments);
    }

    public function displayOnForm()
    {
        $this->displayOnForm = true;

        return $this;
    }
}