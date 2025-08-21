<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Gigabait93\FilamentPages\Models\Page;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->label(__('pages::admin.create_page'))
                    ->icon('heroicon-o-plus'),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label(__('pages::admin.name'))
                    ->getStateUsing(fn(Page $record) => $record->translation()?->name ?? $record->slug),

                TextColumn::make('slug')
                    ->label(__('pages::admin.slug')),

                TextColumn::make('visibility')
                    ->label(__('pages::admin.visibility'))
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label(__('pages::admin.is_active'))
                    ->sortable()
                    ->boolean(),

                TextColumn::make('position')
                    ->label(__('pages::admin.position'))
                    ->badge()
                    ->sortable(),

                TextColumn::make('template')
                    ->label(__('pages::admin.template'))
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('nav_icon')
                    ->icon(fn(Page $record) => Heroicon::tryFrom($record->nav_icon) ?: '')
                    ->label(__('pages::admin.nav_icon'))
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('nav_group')
                    ->label(__('pages::admin.nav_group'))
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('nav_blank')
                    ->label(__('pages::admin.nav_blank'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('page_width')
                    ->label(__('pages::admin.page_width'))
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('createdBy.name')
                    ->label(__('pages::admin.created_by'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updatedBy.name')
                    ->label(__('pages::admin.updated_by'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('published_at')
                    ->label(__('pages::admin.published_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('pages::admin.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label(__('pages::admin.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                Action::make('preview')
                    ->iconButton()
                    ->label(__('pages::admin.preview'))
                    ->icon('heroicon-o-eye')
                    ->url(fn(Page $record) => '/p/' . $record->slug)
                    ->openUrlInNewTab(),
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->filters([
                TrashedFilter::make()->native(false)
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ])
            ]);
    }
}
