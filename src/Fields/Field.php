<?php

namespace PixelBoii\Vague\Fields;

use Illuminate\Support\Str;
use PixelBoii\Vague\Element;

class Field
{
    public $displayOnForm = true;
    public $fillable = true;
    public $nullable = false;
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

    public function span($span)
    {
        $this->columnSpan = $span;

        return $this;
    }

    public function nullable()
    {
        $this->nullable = true;

        return $this;
    }

    public function render($record)
    {
        $column = $this->column;

        return Element::text($record->$column)->setClass('text-sm font-medium text-gray-900');
    }
}