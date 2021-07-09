<?php

namespace PixelBoii\Vague;

class RoleTemplates
{
    public function create($name, $permissions, $level = 5)
    {
        array_push(Vague::$roles, [
            'name' => $name,
            'permissions' => $permissions,
            'level' => $level
        ]);
    }
}