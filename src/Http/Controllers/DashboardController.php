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

    public function search(Request $request)
    {
        return array_reduce(config('vague.resources'), function($resources, $resource) use($request) {
            $search = $request->get('query') ?? '';

            $records = $resource::make()->model()->where(function($query) use($search, $resource) {
                $fields = array_filter($resource::make()->getSearchableFields(), fn ($field) => $field->casts != 'relationship');

                foreach ($fields as $field) {
                    $query->orWhere($field->column, 'LIKE', '%' . $search . '%');
                }
            })->limit(3)->get();

            if (count($records) > 0) {
                array_push($resources, [
                    'name' => $resource::make()->name(),

                    'slug' => $resource::make()->slug(),

                    'records' => $records->map(fn($record) => [
                        'summary' => $resource::make()->bindRecord($record)->summary(),
                        'id' => $record->id
                    ])
                ]);
            }

            return $resources;
        }, []);
    }
}
