<?php

namespace PixelBoii\Vague\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Str;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'resources' => array_map(function($resource) {
                $resource = $resource::make();

                return [
                    'name' => $resource->name(),
                    'record_count' => $resource->model()->count(),
                    'slug' => Str::lower($resource->slug())
                ];
            }, config('vague.resources'))
        ]);
    }
}
