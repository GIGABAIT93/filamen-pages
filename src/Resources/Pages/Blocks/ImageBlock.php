<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;

class ImageBlock
{
    public const NAME = 'image';

    public static function make($defaultSchemaComponents = []): Block
    {
        return Block::make(self::NAME)
            ->label(__('pages::admin.blocks.image_block'))
            ->schema(array_merge($defaultSchemaComponents, [
                FileUpload::make('url')
                    ->label(__('pages::admin.blocks.image'))
                    ->disk('public')
                    ->image()
                    ->required(),
                TextInput::make('alt')
                    ->label(__('pages::admin.blocks.alt_text'))
                    ->maxLength(150),
            ]));
    }
}
