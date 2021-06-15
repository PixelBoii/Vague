<?php

namespace PixelBoii\Vague\Relationships;

use Str;
use PixelBoii\Vague\Relationship;

class BelongsTo extends Relationship
{
    public $type = 'single';

    public $target;
    public $foreignKey;
    public $ownerKey;

    public function __construct($target, $foreignKey = null, $ownerKey = null)
    {
        $this->target = $target;
        $this->foreignKey = $foreignKey ?? Str::snake($target::slug()) . '_id';
        $this->ownerKey = $ownerKey ?? 'id';
    }

    public function buildRelationship($model)
    {
        return $model->belongsTo($this->target()->model(), $this->foreignKey, $this->ownerKey, $this->target()->slug());
    }
}