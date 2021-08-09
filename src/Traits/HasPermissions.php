<?php

namespace PixelBoii\Vague\Traits;

use PixelBoii\Vague\Models\UserPermission;
use PixelBoii\Vague\Models\UserRole;

trait HasPermissions
{
    public function permissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    public function assignRole($roleName)
    {
        UserRole::create([
            'user_id' => $this->id,
            'role' => $roleName
        ]);
    }

    public function revokeRole($roleName)
    {
        UserRole::where([
            'user_id' => $this->id,
            'role' => $roleName
        ])->delete();
    }

    public function permissionMeetsCriteria($ability, $criteria)
    {
        if ($ability == '*') {
            return true;
        }

        return $ability == $criteria;
    }

    public function hasDirectPermission($criteria)
    {
        foreach ($this->permissions as $ability) {
            if ($this->permissionMeetsCriteria($ability['permission'], $criteria)) {
                return true;
            }
        }

        return false;
    }

    public function roles()
    {
        return $this->hasMany(UserRole::class);
    }
    
    public function hasIndirectPermission($criteria)
    {
        foreach ($this->roles as $role) {
            foreach ($role->getPermissions() as $ability) {
                if ($this->permissionMeetsCriteria($ability, $criteria)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function hasPermissions($requirements)
    {
        return collect($requirements)->contains(function($criteria) {
            return $this->hasDirectPermission($criteria) || $this->hasIndirectPermission($criteria);
        });
    }

    public function hasRoles($requirements)
    {
        return collect($requirements)->diff(
            $this->roles->map(fn($role) => $role['role'])
        )->isEmpty();
    }

    public function resources($operation = null)
    {
        return collect(config('vague.resources'))->map(fn($resource) => $resource::make())->filter(fn($resource) => $resource->authorize($operation));
    }
}
