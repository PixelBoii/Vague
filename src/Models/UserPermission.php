<?php

namespace PixelBoii\Vague\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $fillable = ['user_id', 'permission'];

    public function getTable()
    {
        return config('vague.table_names.user_permissions', parent::getTable());
    }
}
