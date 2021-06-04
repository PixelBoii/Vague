<?php

namespace PixelBoii\Vague\Actions;

use PixelBoii\Vague\Element;

class Action
{
    public $name;
    public $method;
    public $element;
    public $id;

    public $visibility = [
        'recordForm' => true,
        'table' => true
    ];

    public function primary()
    {
        $this->element = Element::PrimaryButton($this->name);

        return $this;
    }

    public function secondary()
    {
        $this->element = Element::SecondaryButton($this->name);

        return $this;
    }

    public function danger()
    {
        $this->element = Element::DangerousButton($this->name);

        return $this;
    }

    public function visible($location)
    {
        return $this->visibility[$location];
    }

    public function element($element)
    {
        $this->element = $element;
    }
}