<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class HeroBlock
{
    public const NAME = 'hero';

    public static function make($defaultSchemaComponents = []): Block
    {
        return Block::make(self::NAME)
            ->label(__('pages::admin.blocks.hero.block'))
            ->schema(array_merge($defaultSchemaComponents, [
                TextInput::make('title')
                    ->label(__('pages::admin.blocks.hero.title')),
                Select::make('overlay')
                    ->native(false)
                    ->label(__('pages::admin.blocks.hero.overlay'))
                    ->default(true)
                    ->boolean(),
                TextInput::make('subtitle')
                    ->label(__('pages::admin.blocks.hero.subtitle'))
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label(__('pages::admin.blocks.hero.image'))
                    ->image()
                    ->disk('public')
                    ->directory('pages')
                    ->visibility('public')
                    ->columnSpanFull(),
            ]))->columns(2);
    }
}
