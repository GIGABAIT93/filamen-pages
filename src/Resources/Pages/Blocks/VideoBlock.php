<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class VideoBlock
{
    public const NAME = 'video';

    public static function make($defaultSchemaComponents = []): Block
    {
        return Block::make(self::NAME)
            ->label(__('pages::admin.blocks.video.block'))
            ->schema(array_merge($defaultSchemaComponents, [
                TextInput::make('url')
                    ->label(__('pages::admin.blocks.video.url'))
                    ->required()
                    ->url()
                    ->placeholder('https://www.youtube.com/watch?v=...'),
                Textarea::make('caption')
                    ->label(__('pages::admin.blocks.video.caption'))
                    ->rows(2),
            ]))->columns(1);
    }
}
