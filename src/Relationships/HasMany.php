<?php

namespace PixelBoii\Vague\Relationships;

use PixelBoii\Vague\Relationship;

class HasMany extends Relationship
{
    public $type = 'many';

    public $target;
    public $foreignKey;
    public $localKey;

    public function __construct($target, $foreignKey = null, $localKey = null)
    {
        $this->target = $target;
        $this->foreignKey = $foreignKey;
        $this->localKey = $localKey;
    }

    public function buildRelationship($model)
    {
        return $model->hasMany($this->target()->model()::class, $this->foreignKey, $this->localKey, $this->target()->slug());
    }
}