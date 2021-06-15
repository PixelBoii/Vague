<?php

namespace PixelBoii\Vague\Fields;

class ID extends Field
{
    public $casts = 'number';
    public $fillable = false;

    public function __construct($name = 'id', $column = null)
    {
        parent::__construct($name, $column);
    }
}