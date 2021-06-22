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
    public $view;

    public function __construct($resource, $relationship, $view = 'summary', $name = null)
    {
        if (is_string($relationship)) {
            $relationship = $resource->$relationship();
        }

        if ($relationship instanceof BelongsTo) {
            $this->column = $relationship->foreignKey;
        } else {
            /* Relationship doesn't have a local key, so don't show on form */
            $this->displayOnForm = false;
        }

        $this->relationship = $relationship;
        $this->name = $name ?? $relationship->target()->name();
        $this->view = $view;
    }

    public function render($record)
    {
        $view = $this->view;

        return $this->relationship->dontLink()->$view();
    }
}