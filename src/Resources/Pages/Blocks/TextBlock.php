<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;

class TextBlock
{
    public const NAME = 'text';

    public static function make($defaultSchemaComponents = []): Block
    {
        return Block::make(self::NAME)
            ->label(__('pages::admin.blocks.text_block'))
            ->schema(array_merge($defaultSchemaComponents, [
                Textarea::make('content')
                    ->label(__('pages::admin.blocks.text.html'))
                    ->required(),
            ]));
    }
}
