<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\RichEditor;

class RichTextBlock
{
    public const NAME = 'rich_text';

    public static function make($defaultSchemaComponents = []): Block
    {
        return Block::make(self::NAME)
            ->label('RichEditor')
            ->schema(array_merge($defaultSchemaComponents, [
                RichEditor::make('html')
                    ->label(__('pages::admin.blocks.text.html'))
                    ->columnSpanFull(),
            ]))->columns(1);
    }
}

