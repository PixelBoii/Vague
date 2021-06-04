<?php

namespace PixelBoii\Vague\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'vague::app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth.user' => fn () => $request->user(),

            'auth.summary' => function() use($request) {
                $resource = config('vague.user.resource')::make();
                $method = config('vague.user.sidebar');

                return $resource->$method($request->user());
            },

            'quickSearch.results' => fn () => array_reduce(config('vague.resources'), function($resources, $resource) use($request) {
                $search = $request->get('quickSearch') ?? '';

                $records = $resource::$model::where(function($query) use($search, $resource) {
                    $fields = $resource::$searchable ?? array_map(fn($field) => $field->column, $resource::make()->resolveFields());

                    foreach ($fields as $field) {
                        $query->orWhere($field, 'LIKE', '%' . $search . '%');
                    }
                })->limit(6)->get();

                if (count($records) > 0) {
                    array_push($resources, [
                        'name' => $resource::make()->name(),
    
                        'slug' => $resource::make()->slug(),
    
                        'records' => $records->map(fn($record) => [
                            'summary' => $resource::make()->summary($record),
                            'id' => $record->id
                        ])
                    ]);
                }

                return $resources;
            }, []),

            'config.prefix' => config('vague.prefix'),

            'config.app_name' => config('vague.app_name'),
        ]);
    }
}