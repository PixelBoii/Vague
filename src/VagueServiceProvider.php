<?php

namespace PixelBoii\Vague;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

use PixelBoii\Vague\Console\{InstallPackage, MakeResource};
use PixelBoii\Vague\Http\Middleware\HandleInertiaRequests;
use PixelBoii\Vague\ResourceFields;

class VagueServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallPackage::class,
                MakeResource::class,
            ]);
        }

        $this->registerPublishing();
        $this->registerViews();
        $this->registerRoutes();
        $this->registerLengthAwarePaginator();
    }

    protected function registerBladeField($field)
    {
        Blade::component('vague::components.fields.' . $field, 'vague-' . $field);
    }

    protected function registerBladeComponent($component)
    {
        Blade::component('vague::components.' . $component, 'vague-' . $component);
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'vague');
    }

    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/vague.php' => config_path('vague.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/vague'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../stubs/Vague' => app_path('Vague'),
        ], 'base');
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('vague.prefix'),
            'middleware' => [...config('vague.middleware'), HandleInertiaRequests::class],
        ];
    }

    protected function registerLengthAwarePaginator()
    {
        $this->app->bind(LengthAwarePaginator::class, function ($app, $values) {
            return new class(...array_values($values)) extends LengthAwarePaginator {
                public function toArray()
                {
                    return [
                        'data' => $this->items->toArray(),
                        'links' => $this->links(),
                    ];
                }

                public function items()
                {
                    return $this->items;
                }

                public function links($view = null, $data = [])
                {
                    $this->appends(Request::all());

                    $window = UrlWindow::make($this);

                    $elements = array_filter([
                        $window['first'],
                        is_array($window['slider']) ? '...' : null,
                        $window['slider'],
                        is_array($window['last']) ? '...' : null,
                        $window['last'],
                    ]);

                    return Collection::make($elements)->flatMap(function ($item) {
                        if (is_array($item)) {
                            return Collection::make($item)->map(function ($url, $page) {
                                return [
                                    'url' => $url,
                                    'label' => $page,
                                    'active' => $this->currentPage() === $page,
                                ];
                            });
                        } else {
                            return [
                                [
                                    'url' => null,
                                    'label' => '...',
                                    'active' => false,
                                ],
                            ];
                        }
                    })->prepend([
                        'url' => $this->previousPageUrl(),
                        'label' => 'Previous',
                        'active' => false,
                    ])->push([
                        'url' => $this->nextPageUrl(),
                        'label' => 'Next',
                        'active' => false,
                    ]);
                }
            };
        });
    }
}