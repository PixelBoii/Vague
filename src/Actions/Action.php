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

    public $confirmation = false;
    public $modal;

    public function primary()
    {
        $this->element = Element::PrimaryButton($this->name);

        return $this;
    }

    public function name($name)
    {
        $this->name = $name;

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

    public function confirmation($fn = null)
    {
        $this->confirmation = true;
        $this->modal = new Modal($this);

        $this->modal->body([
            Element::text('Perform ' . $this->name)->setClass('text-lg font-medium'),
            Element::text("This is just a confirmation window, don't worry about it.")->setClass('mt-2 text-base font-medium text-gray-500'),
        ]);

        if (isset($fn) && is_callable($fn)) {
            $fn($this->modal);
        }

        return $this;
    }
}