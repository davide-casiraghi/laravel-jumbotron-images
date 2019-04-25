<?php

namespace DavideCasiraghi\LaravelJumbotronImages;

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
//use DavideCasiraghi\LaravelJumbotronImages\Console\ResponsiveQuote;
//use DavideCasiraghi\LaravelJumbotronImages\Http\Controllers\ResponsiveQuoteController;
class LaravelJumbotronImagesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-jumbotron-images');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-jumbotron-images');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        if (! class_exists('CreateQuotesTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_jumbotron_images_table.php.stub' => database_path('migrations/'.Carbon::now()->format('Y_m_d_Hmsu').'_create_jumbotron_images_table.php'),
            ], 'migrations');
        }
        if (! class_exists('CreateQuoteTranslationsTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_jumbotron_image_translations_table.php.stub' => database_path('migrations/'.Carbon::now()->format('Y_m_d_Hmsu').'_create_jumbotron_image_translations_table.php'),
            ], 'migrations');
        }
        
        
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-jumbotron-images.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-jumbotron-images'),
            ], 'views');

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-jumbotron-images'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-jumbotron-images'),
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
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-jumbotron-images');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-jumbotron-images', function () {
            return new LaravelJumbotronImages;
        });
    }
}
