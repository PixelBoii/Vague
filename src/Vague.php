<?php

namespace PixelBoii\Vague;

class Vague
{
    public static $roles = [];
    public static $elements = [];

    public static function roles(Callable $fn)
    {
        $fn(new RoleTemplates);

        return new static;
    }

    public static function resetElements()
    {
        self::$elements = [];
    }

    public static function registerElement(&$element)
    {
        $id = count(self::$elements);
        self::$elements[$id] = $element;

        return $id;
    }
}