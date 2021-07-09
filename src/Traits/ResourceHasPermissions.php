<?php

namespace PixelBoii\Vague\Traits;

use PixelBoii\Vague\Resources\UserRole;
use PixelBoii\Vague\Resources\UserPermission;
use PixelBoii\Vague\Element;
use PixelBoii\Vague\Vague;

trait ResourceHasPermissions
{
    public function roles()
    {
        return $this->hasMany(UserRole::class);
    }

    public function permissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    public function permissionManager()
    {
        return Element::div([
            $this->roles()->stackedList(10)->class('rounded-md border border-gray-200 divide-y divide-gray-200 overflow-hidden shadow-sm'),

            Element::select(
                array_map(fn($role) => (
                    Element::text($role['name'])->onClick(function() use($role) {
                        $this->model()->whereId($this->record->id)->first()->assignRole($role['name']);
                    })
                ), Vague::$roles)
            )
        ])->class('space-y-2');
    }
}
