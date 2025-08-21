<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;

class GalleryBlock
{
    public const NAME = 'gallery';

    public static function make($defaultSchemaComponents = []): Block
    {
        return Block::make(self::NAME)
            ->label(__('pages::admin.blocks.gallery.block'))
            ->schema(array_merge($defaultSchemaComponents, [
                FileUpload::make('images')
                    ->label(__('pages::admin.blocks.gallery.images'))
                    ->image()
                    ->multiple()
                    ->disk('public')
                    ->directory('pages')
                    ->visibility('public')
                    ->minFiles(1),
            ]))->columns(1);
    }
}
