<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Blocks;


use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class DividerBlock
{
    public const NAME = 'divider';

    public static function make($defaultSchemaComponents = []): Block
    {
        return Block::make(self::NAME)
            ->label(__('pages::admin.blocks.divider.block'))
            ->schema(array_merge($defaultSchemaComponents, [
                Select::make('style')
                    ->label(__('pages::admin.blocks.divider.style'))
                    ->options([
                        'solid' => __('pages::admin.blocks.divider.styles.solid'),
                        'dashed' => __('pages::admin.blocks.divider.styles.dashed'),
                        'dotted' => __('pages::admin.blocks.divider.styles.dotted'),
                    ])
                    ->default('solid')
                    ->native(false),
                TextInput::make('label')
                    ->label(__('pages::admin.blocks.divider.label'))
                    ->placeholder(__('pages::admin.blocks.divider.placeholder')),
            ]))->columns(2);
    }
}
