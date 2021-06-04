<?php

namespace PixelBoii\Vague\Relationships;

use PixelBoii\Vague\Relationship;

class HasManyThrough extends Relationship
{
    public $type = 'many';

    public $target;
    public $through;
    public $firstKey;
    public $secondKey;
    public $localKey;
    public $secondLocalKey;

    public function __construct($target, $through, $firstKey = null, $secondKey = null, $localKey = null, $secondLocalKey = null)
    {
        $this->target = $target;
        $this->through = $through;
        $this->firstKey = $firstKey;
        $this->secondKey = $secondKey;
        $this->localKey = $localKey;
        $this->secondLocalKey = $secondLocalKey;
    }

    public function through()
    {
        return new $this->through();
    }

    public function buildRelationship($model)
    {
        return $model->hasManyThrough($this->target()->model()::class, $this->through()->model()::class, $this->firstKey, $this->secondKey, $this->localKey, $this->secondLocalKey, $this->target()->slug());
    }
}