<?php

namespace PixelBoii\Vague;

trait DashboardView
{
    public static function name()
    {
        return class_basename(new static());
    }

    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }
}