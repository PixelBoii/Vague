<?php

namespace PixelBoii\Vague\Relationships;

use PixelBoii\Vague\Relationship;

class BelongsToMany extends Relationship
{
    public $type = 'many';

    public $target;
    public $pivot;
    public $foreignPivotKey;
    public $targetPivotKey;
    public $parentKey;
    public $relatedKey;

    public function __construct($target, $pivot, $foreignPivotKey = null, $targetPivotKey = null, $parentKey = null, $relatedKey = null)
    {
        $this->target = $target;
        $this->pivot = $pivot;
        $this->foreignPivotKey = $foreignPivotKey;
        $this->targetPivotKey = $targetPivotKey;
        $this->parentKey = $parentKey;
        $this->relatedKey = $relatedKey;
    }

    public function pivot()
    {
        return new $this->pivot();
    }

    public function buildRelationship($model)
    {
        return $model->belongsToMany($this->target()->model()::class, $this->pivot()->model()::class, $this->foreignPivotKey, $this->targetPivotKey, $this->parentKey, $this->relatedKey, $this->target()->slug());
    }
}