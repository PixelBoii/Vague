<?php

namespace PixelBoii\Vague\Fields;

class Id extends Field
{
    public $casts = 'number';
    public $fillable = false;

    public function __construct($resource, $name = 'id', $column = null)
    {
        parent::__construct($resource, $name, $column);
    }
}