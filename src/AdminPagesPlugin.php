<?php

namespace Gigabait93\FilamentPages;

use Filament\Contracts\Plugin as PluginContract;
use Filament\Panel;

class AdminPagesPlugin implements PluginContract
{
    public static function make()
    {
        return app(self::class);
    }

    public function getId(): string
    {
        return 'pages';
    }

    public function register(Panel $panel): void
    {
        $panel->discoverResources(in: __DIR__ . '/Resources', for: 'Gigabait93\FilamentPages\Resources');
    }

    public function boot(Panel $panel): void
    {
        // No additional boot logic needed for the admin plugin.
    }
}
