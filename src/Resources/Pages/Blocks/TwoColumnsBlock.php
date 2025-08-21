<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Blocks;


use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;

class TwoColumnsBlock
{
    public const NAME = 'two_columns';

    public static function make($defaultSchemaComponents = []): Block
    {
        return Block::make(self::NAME)
            ->label(__('pages::admin.blocks.two_columns.block'))
            ->schema(array_merge($defaultSchemaComponents, [
                Select::make('ratio')
                    ->label(__('pages::admin.blocks.two_columns.ratio'))
                    ->options([
                        '6-6' => __('pages::admin.blocks.two_columns.ratios.6_6'),
                        '8-4' => __('pages::admin.blocks.two_columns.ratios.8_4'),
                        '4-8' => __('pages::admin.blocks.two_columns.ratios.4_8'),
                    ])
                    ->columnSpanFull()
                    ->default('6-6')
                    ->native(false),

                RichEditor::make('left')
                    ->label(__('pages::admin.blocks.two_columns.left')),

                RichEditor::make('right')
                    ->label(__('pages::admin.blocks.two_columns.right')),
            ]))->columns(2);
    }
}
