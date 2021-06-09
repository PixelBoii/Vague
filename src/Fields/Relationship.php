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
        $this->column = $targetKey;
        $this->name = $relationship->target()->name();
        $this->relationship = $relationship;
    }

    public function onRender($record)
    {
        $this->element = $this->relationship->summary($record, false);
    }
}