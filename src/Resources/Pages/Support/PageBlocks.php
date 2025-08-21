<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Support;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\CheckboxList;

class PageBlocks
{
    /**
     * @throws \Exception
     */
    public static function all(): array
    {
        $blocks = [];
        foreach (glob(__DIR__ . '/../Blocks/*.php') as $filePath) {
            $className = 'Gigabait93\FilamentPages\Resources\Pages\Blocks\\' . pathinfo($filePath, PATHINFO_FILENAME);
            if ($className !== self::class && class_exists($className) && method_exists($className, 'make')) {
                /** @var Block $block */
                $block = $className::make(self::defaultSchemaComponents());
//                $block->preview('pages::blocks.simple.' . $className::NAME);
                $blocks[] = $block;
            }
        }
        return $blocks;
    }

    public static function defaultSchemaComponents(): array
    {
        return [
            CheckboxList::make('global')
                ->label(__('pages::admin.blocks.section_settings'))
                ->options([
                    'use_section' => __('pages::admin.blocks.global_section'),
                    'use_compact' => __('pages::admin.blocks.global_compact'),
                ])->afterStateHydrated(function ($component, $state) {
                    $list = collect((array)$state)
                        ->filter(fn($v) => filter_var($v, FILTER_VALIDATE_BOOLEAN))
                        ->keys()
                        ->all();

                    $component->state($list);
                })
                ->dehydrateStateUsing(function ($state) {
                    $state = (array)$state;

                    return [
                        'use_section' => in_array('use_section', $state, true),
                        'use_compact' => in_array('use_compact', $state, true),
                    ];
                })
                ->columns(2)
                ->columnSpanFull()
        ];

    }
}
