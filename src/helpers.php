<?php

use Filament\Facades\Filament;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

if (!function_exists('page_normalize_blocks')) {
    function page_normalize_blocks($content): array
    {
        if ($content === null || $content === '') {
            return [];
        }

        if (is_string($content)) {
            $decoded = json_decode($content, true);
            $content = is_array($decoded) ? $decoded : [];
        }

        if (!is_array($content)) {
            return [];
        }

        $isAssoc = array_keys($content) !== range(0, count($content) - 1);
        if ($isAssoc) {
            $content = array_values($content);
        }

        return array_values(array_filter($content, function ($item) {
            return is_array($item) && isset($item['type']);
        }));
    }
}

if (!function_exists('page_media_url')) {
    function page_media_url(?string $path, string $disk = 'public'): ?string
    {
        return $path ? Storage::disk($disk)->url($path) : null;
    }
}

if (!function_exists('localesOptions')) {
    function localesOptions(): array
    {
        $scan = scandir(base_path('lang'));
        if ($scan === false) {
            return [];
        }
        $languages = array_filter($scan, function ($item) {
            if ($item === 'vendor') return false; // Skip vendor directory
            return $item !== '.' && $item !== '..' && is_dir(base_path('lang/' . $item));
        });
        return array_values($languages);
    }
}

if (!function_exists('templatesOptions')) {
    function templatesOptions(): array
    {
        $publishedPath = resource_path('views/vendor/pages/blocks');
        $packagePath   = __DIR__ . '/../views/blocks';

        $scan = function (string $path) {
            if (!is_dir($path)) {
                return collect();
            }

            return collect(File::directories($path))
                ->mapWithKeys(function ($dir) {
                    $name = basename($dir);
                    return [$name => $name];
                });
        };

        $merged = $scan($packagePath)->merge($scan($publishedPath));

        return $merged
            ->keys()
            ->mapWithKeys(fn ($name) => [$name => ucfirst($name)])
            ->toArray();
    }
}

if (!function_exists('iconsOptions')) {
    function iconsOptions(): array
    {
        $icons = Heroicon::cases();
        return collect($icons)->mapWithKeys(function ($icon) {
            return [$icon->value => $icon->name];
        })->toArray();
    }
}

if (!function_exists('navigationGroupsOptions')) {
    function navigationGroupsOptions(): array
    {
        $panelsIds = config('pages.clients_panels_ids');
        $groups = [];
        if (is_array($panelsIds) && count($panelsIds) > 0) {
            foreach ($panelsIds as $panelId) {
                if ($p = Filament::getPanel($panelId)) {
                    $groups = array_merge($groups, $p->getNavigationGroups() ?: []);
                }
            }
        } else {
            $groups = Filament::getCurrentOrDefaultPanel()->getNavigationGroups();
        }
        return collect($groups)->mapWithKeys(function ($group) {
            return [$group->getLabel()];
        })->toArray();
    }
}

if (!function_exists('pageWidthsOptions')) {
    function pageWidthsOptions(): array
    {
        $widths = Width::cases();
        return collect($widths)->mapWithKeys(function ($width) {
            return [$width->value => $width->name];
        })->toArray();
    }
}