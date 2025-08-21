<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\MarkdownEditor;

class MarkdownTextBlock
{
    public const NAME = 'markdown_text';

    public static function make($defaultSchemaComponents = []): Block
    {
        return Block::make(self::NAME)
            ->label('MarkdownEditor')
            ->schema(array_merge($defaultSchemaComponents, [
                MarkdownEditor::make('html')
                    ->label(__('pages::admin.blocks.text.html'))
                    ->columnSpanFull(),
            ]))->columns(1);
    }
}

