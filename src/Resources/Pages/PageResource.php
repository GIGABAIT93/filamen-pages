<?php

namespace Gigabait93\FilamentPages\Resources\Pages;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Gigabait93\FilamentPages\Models\Page;
use Gigabait93\FilamentPages\Resources\Pages\Pages\CreatePage;
use Gigabait93\FilamentPages\Resources\Pages\Pages\EditPage;
use Gigabait93\FilamentPages\Resources\Pages\Pages\ListPages;
use Gigabait93\FilamentPages\Resources\Pages\Schemas\PageForm;
use Gigabait93\FilamentPages\Resources\Pages\Tables\PagesTable;
use UnitEnum;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-document-text';
    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return config('pages.admin_navigation_group', null);
    }

    /**
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return self::getNavigationLabel();
    }

    public static function getNavigationLabel(): string
    {
        return __('pages::admin.pages');
    }

    public static function form(Schema $schema): Schema
    {
        return PageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PagesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
