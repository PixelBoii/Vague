<?php

namespace PixelBoii\Vague\Models;

use Illuminate\Database\Eloquent\Model;
use PixelBoii\Vague\Vague;

class UserRole extends Model
{
    protected $fillable = ['user_id', 'role'];

    public function getTable()
    {
        return config('vague.table_names.user_roles', parent::getTable());
    }

    public function getRole()
    {
        return collect(Vague::$roles)->firstWhere('name', $this->role);
    }

    public function getLevel()
    {
        return $this->getRole()['level'] ?? null;
    }

    public function getPermissions()
    {
        return $this->getRole()['permissions'] ?? [];
    }
}
