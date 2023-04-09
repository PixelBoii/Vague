<?php

namespace PixelBoii\Vague;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

use PixelBoii\Vague\Console\{InstallPackage, MakeResource};
use PixelBoii\Vague\Http\Middleware\HandleInertiaRequests;

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
            __DIR__.'/../database/migrations/2021_06_23_204918_create_permission_tables.php' => database_path('migrations/2021_06_23_204918_create_permission_tables.php'),
        ], 'permission-migrations');

        $this->publishes([
            __DIR__.'/../public/vendor/vague' => public_path('vendor/vague'),
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
            'middleware' => [...config('vague.middleware') ?? [], HandleInertiaRequests::class],
        ];
    }
}
