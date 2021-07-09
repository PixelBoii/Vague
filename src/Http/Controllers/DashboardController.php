<?php

namespace PixelBoii\Vague\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Str;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Dashboard', [
            'resources' => array_reduce(config('vague.resources'), function($resources, $resource) use($request) {
                $resource = $resource::make();

                if ($request->user()->can('view ' . strtolower($resource->name()))) {
                    array_push($resources, [
                        'name' => $resource->name(),
                        'record_count' => $resource->model()->count(),
                        'slug' => Str::lower($resource->slug())
                    ]);
                }

                return $resources;
            }, [])
        ]);
    }
}
