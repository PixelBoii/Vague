<?php

namespace PixelBoii\Vague\Fields;

use Str;
use Exception;
use PixelBoii\Vague\Relationships\BelongsTo;

class Relationship extends Field
{
    public $casts = 'relationship';
    public $displayOnForm = true;

    public $relationship;

    public function __construct($relationship, $column = null)
    {
        if ($relationship instanceof BelongsTo) {
            $this->column = $column ?? $relationship->target()->slug();
        } else {
            /* Relationship doesn't have a local key, so don't show on form */
            $this->displayOnForm = false;
        }

        $this->relationship = $relationship;
        $this->name = $column ? Str::of($column)->replace('_', ' ')->ucFirst() : $relationship->target()->name();
    }

    public function render($record)
    {
        return $this->relationship->summary()->hideTitle()->disableLink();
    }
}