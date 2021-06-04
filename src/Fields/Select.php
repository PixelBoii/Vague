<?php

namespace PixelBoii\Vague\Fields;

class Select extends Field
{
    public string $casts = 'select';
    public $options = [];

    public function options($options)
    {
        $this->options = $options;

        return $this;
    }
}