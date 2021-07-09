<?php

use App\Http\Middleware\HandleVagueRequest;
use Pixel\Vague\Features;

return [
    'resources' => [
        App\Vague\User::class,
    ],

    'features' => [
        Features::permissions()
    ],

    'table_names' => [
        'user_roles' => 'user_roles',
        'user_permissions' => 'user_permissions',
    ],

    'user' => [
        'resource' => App\Vague\User::class,
        'sidebar' => 'sidebar'
    ],

    'prefix' => 'vague',

    'middleware' => ['web', 'auth:web', HandleVagueRequest::class],

    'app_name' => 'Vague Admin Panel'
];