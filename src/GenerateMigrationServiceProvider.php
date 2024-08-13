<?php

namespace Developerawam\GenerateMigration;

use Illuminate\Support\ServiceProvider;

class GenerateMigrationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */

        // Load package views
        $this->loadViewsFrom(__DIR__.'/../src/resources/views', 'generate-ui');

        // load package routes
        $this->loadRoutesFrom(__DIR__.'/../src/routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('generate-migration.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../src/resources/views' => resource_path('views/vendor/generate-migration'),
            ], 'views');

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/generate-migration'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/generate-migration'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'generate-migration');

        // Register the main class to use with the facade
        $this->app->singleton('generate-migration', function () {
            return new GenerateMigration;
        });
    }
}
