<?php

namespace PixelBoii\Vague\Relationships;

use PixelBoii\Vague\Relationship;

class HasOne extends Relationship
{
    public $type = 'single';

    public function buildRelationship($model)
    {
        return $model->hasOne($this->target, ...$this->arguments);
    }
}