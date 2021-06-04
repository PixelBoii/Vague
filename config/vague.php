<?php

use App\Http\Middleware\HandleVagueRequest;

return [
    'resources' => [
        App\Vague\User::class,
    ],

    'user' => [
        'resource' => App\Vague\User::class,
        'sidebar' => 'sidebar'
    ],

    'prefix' => 'vague',

    'middleware' => ['web', 'auth:web', HandleVagueRequest::class],

    'app_name' => 'Vague Admin Panel'
];