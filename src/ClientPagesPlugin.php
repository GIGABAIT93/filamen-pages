<?php

namespace Gigabait93\FilamentPages;

use Filament\Contracts\Plugin as PluginContract;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\Support\Icons\Heroicon;
use Gigabait93\FilamentPages\Models\Page;
use Gigabait93\FilamentPages\Pages\Show;

class ClientPagesPlugin implements PluginContract
{
    public static function make()
    {
        return app(self::class);
    }

    public function getId(): string
    {
        return 'filament-pages-client';
    }

    public function register(Panel $panel): void
    {
        $panel->pages([Show::class]);
        $pages = Page::query()
            ->with('translations')
            ->where('is_active', true)
            ->orderBy('position')
            ->get();

        $items = $pages->map(function (Page $page) {
            return NavigationItem::make()
                ->label(fn() => $page->translation()?->name ?? $page->slug)
                ->sort($page->position ?? 5)
                ->icon(Heroicon::tryFrom($page->nav_icon) ?? null)
                ->group($page->nav_group ?? null)
                ->openUrlInNewTab($page->nav_blank ?? false)
                ->url(fn() => Show::getUrl(['slug' => $page->slug]))
                ->visible(fn() => $page->canVisibility())
                ->isActiveWhen(fn() => request()->routeIs(Show::getRouteName()) &&
                    request()->route('slug') === $page->slug
                );
        })->all();

        $panel->navigationItems($items);
    }

    public function boot(Panel $panel): void
    {
        // No additional boot logic needed for the client plugin.
    }
}
