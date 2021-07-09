<?php

namespace PixelBoii\Vague;

class Features
{
    public static function enabled($feature)
    {
        return in_array($feature, config('vague.features') ?? []);
    }

    public static function permissions()
    {
        return 'permissions';
    }
}