<?php

namespace Dmilho\Wiredboot;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class WiredbootServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        Blade::directive('wiredboot', function ($expression) {
            // trim single quote and set component name
            $name = trim($expression, "'");
            return "<?= resolve('App\Http\Wiredboot\\{$name}'); ?>";
        });
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'dmilho');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'dmilho');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
        $this->bootForConsole();
        }
    }

/**
* Register any package services.
*
* @return void
*/
public function register(): void
{
$this->mergeConfigFrom(__DIR__.'/../config/wiredboot.php', 'wiredboot');
}

/**
* Get the services provided by the provider.
*
* @return array
*/
public function provides()
{
return ['wiredboot'];
}

/**
* Console-specific booting.
*
* @return void
*/
protected function bootForConsole(): void
{
// Publishing the configuration file.
$this->publishes([
__DIR__.'/../config/wiredboot.php' => config_path(path: 'wiredboot.php'),
], 'config');

// Publishing the views.
$this->publishes([
__DIR__.'/resources/views' => resource_path('resources/views'),
], 'views');

// Publishing assets.
/*$this->publishes([
__DIR__.'/../resources/assets' => public_path('vendor/dmilho'),
], 'wiredboot.views');*/

// Publishing the translation files.
/*$this->publishes([
__DIR__.'/../resources/lang' => resource_path('lang/vendor/dmilho'),
], 'wiredboot.views');*/

// Registering package commands.
// $this->commands([]);
}
}
