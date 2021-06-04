<?php

namespace PixelBoii\Vague\Http\Helpers;

use Exception;

class ResourceHelper
{
    public static function getModel($resource)
    {
        foreach (config('vague.resources') as $model) {
            if (strtolower($model::make()->slug()) == strtolower($resource)) {
                return new $model();
            }
        }

        return null;
    }

    public static function getModelOrFail($resource)
    {
        $resource = self::getModel($resource);

        if (!isset($resource)) {
            throw new Exception('Resource ' . $resource . ' not found');
        }

        return $resource;
    }
}