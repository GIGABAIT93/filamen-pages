<?php

namespace Gigabait93\FilamentPages\Providers;

use Illuminate\Support\ServiceProvider;

class FilamentPagesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/pages.php', 'pages');
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'pages');
        $this->loadViewsFrom(__DIR__ . '/../../views', 'pages');

        $this->publishes([
            __DIR__ . '/../../config/pages.php' => config_path('pages.php'),
            __DIR__ . '/../../lang' => resource_path('lang/vendor/pages'),
            __DIR__ . '/../../views' => resource_path('views/vendor/pages'),
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'filament-pages');

        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'filament-pages-migrations');

        $this->publishes([
            __DIR__ . '/../../lang' => resource_path('lang/vendor/pages'),
        ], 'filament-pages-translations');

        $this->publishes([
            __DIR__ . '/../../views' => resource_path('views/vendor/pages'),
        ], 'filament-pages-views');

        $this->publishes([
            __DIR__ . '/../../config/pages.php' => config_path('pages.php'),
        ], 'filament-pages-config');
    }
}
