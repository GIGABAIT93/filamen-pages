<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ButtonBlock
{
    public const NAME = 'button';

    public static function make($defaultSchemaComponents = []): Block
    {
        return Block::make(self::NAME)
            ->label(__('pages::admin.blocks.button.block'))
            ->schema(array_merge($defaultSchemaComponents, [
                TextInput::make('label')
                    ->label(__('pages::admin.blocks.button.label'))
                    ->required(),
                TextInput::make('url')
                    ->label(__('pages::admin.blocks.button.url'))
                    ->required()
                    ->url(),
                Select::make('style')
                    ->label(__('pages::admin.blocks.button.style'))
                    ->options([
                        'primary' => __('pages::admin.blocks.button.styles.primary'),
                        'secondary' => __('pages::admin.blocks.button.styles.secondary'),
                        'success' => __('pages::admin.blocks.button.styles.success'),
                        'danger' => __('pages::admin.blocks.button.styles.danger'),
                        'warning' => __('pages::admin.blocks.button.styles.warning'),
                        'info' => __('pages::admin.blocks.button.styles.info'),
                    ])
                    ->default('primary')
                    ->native(false),
                Toggle::make('new_tab')
                    ->label(__('pages::admin.blocks.button.new_tab'))
                    ->default(false)
            ]))
            ->columns(2);
    }
}
