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

                return $resource->bindRecord($request->user())->$method();
            },

            'config.prefix' => config('vague.prefix'),

            'config.app_name' => config('vague.app_name'),
        ]);
    }
}