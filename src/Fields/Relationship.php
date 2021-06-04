<?php

namespace PixelBoii\Vague\Fields;

use Str;

class Relationship extends Field
{
    public $casts = 'relationship';
    public $displayOnForm = false;

    public $relationship;
    public $element;

    public function __construct($relationship, $targetKey = null)
    {
        if (is_null($targetKey)) {
            $this->column = $relationship->foreignKey ?? Str::snake($relationship->target()->slug()) . '_id';
        } else {
            $this->column = $targetKey;
        }

        $this->name = $relationship->target()->name();
        $this->relationship = $relationship;
    }

    public function onRender($record)
    {
        $this->element = $this->relationship->summary($record, false);
    }
}