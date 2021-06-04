<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class Grid extends Div
{
    public $gap = 6;
    public $cols = 2;

    public function getClass()
    {
        return implode(' ', [
            ...$this->attributes['class'] ?? [],
            'grid',
            'gap-' . $this->gap,
            'grid-cols-' . $this->cols
        ]);
    }

    public function gap($gap)
    {
        $this->gap = $gap;

        return $this;
    }

    public function cols($cols)
    {
        $this->cols = $cols;

        return $this;
    }
}