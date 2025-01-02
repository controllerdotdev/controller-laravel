<?php

namespace Controller;

use Illuminate\Support\ServiceProvider;

class ControllerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/controller.php', 'controller');

        $this->app->singleton('controller', function ($app) {
            return new ControllerClient(
                config('controller.api_key'),
                config('controller.endpoint')
            );
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/controller.php' => config_path('controller.php'),
        ], 'config');
    }
}
