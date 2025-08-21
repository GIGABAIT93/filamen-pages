<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Gigabait93\FilamentPages\Models\Page;
use Gigabait93\FilamentPages\Resources\Pages\Support\PageBlocks;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        $locales = localesOptions();
        $defaultLocale = $locales[0] ?? app()->getLocale();
        $templates = templatesOptions();

        return $schema->schema([
            Section::make(__('pages::admin.page'))
                ->key('pages')
                ->columnSpanFull()
                ->collapsible()
                ->columns(4)
                ->schema([
                    TextInput::make('slug')
                        ->label(__('pages::admin.slug'))
                        ->maxLength(191)
                        ->required()
                        ->columnSpan(2)
                        ->unique(ignoreRecord: true),

                    TextInput::make('position')
                        ->label(__('pages::admin.position'))
                        ->numeric()
                        ->minValue(0)
                        ->columnSpan(2)
                        ->default(Page::count() + 1),

                    Select::make('template')
                        ->label(__('pages::admin.template'))
                        ->default('simple')
                        ->native(false)
                        ->required()
                        ->options($templates),

                    Select::make('is_active')
                        ->native(false)
                        ->boolean()
                        ->label(__('pages::admin.is_active'))
                        ->default(true),

                    Select::make('visibility')
                        ->native(false)
                        ->label(__('pages::admin.visibility'))
                        ->options([
                            'public' => __('pages::admin.public'),
                            'auth' => __('pages::admin.auth'),
                            'private' => __('pages::admin.private'),
                        ])
                        ->default('public')
                        ->required(),

                    DateTimePicker::make('published_at')
                        ->label(__('pages::admin.published_at'))
                        ->seconds(false)
                        ->native(false)
                        ->default(now())
                        ->required()
                        ->nullable(),

                    Select::make('nav_icon')
                        ->label(__('pages::admin.nav_icon'))
                        ->native(false)
                        ->searchable()
                        ->optionsLimit(10000)
                        ->options(fn() => iconsOptions()),

                    TextInput::make('nav_group')
                        ->label(__('pages::admin.nav_group'))
                        ->maxLength(64)
                        ->datalist(fn() => navigationGroupsOptions()),

                    Select::make('nav_blank')
                        ->label(__('pages::admin.nav_blank'))
                        ->native(false)
                        ->boolean()
                        ->default(false),

                    Select::make('page_width')
                        ->label(__('pages::admin.page_width'))
                        ->native(false)
                        ->options(pageWidthsOptions()),
                ]),

            Section::make(__('pages::admin.content'))
                ->key('translatable')
                ->columnSpanFull()
                ->collapsible()
                ->columns(1)
                ->schema([self::getPagesTranslationForm($locales, $defaultLocale)]),
        ]);
    }

    private static function getPagesTranslationForm(array $locales, string $defaultLocale): Tabs
    {
        return Tabs::make(__('pages::admin.translations'))
            ->tabs(
                collect($locales)->map(function (string $locale) use ($locales, $defaultLocale) {
                    return Tab::make(strtoupper($locale))
                        ->schema([
                            TextInput::make("translations.{$locale}.name")
                                ->label(__('pages::admin.name'))
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (?string $state, Set $set, Get $get) use ($locale, $defaultLocale) {
                                    if (empty($get('slug')) and $locale === $defaultLocale && filled($state)) {
                                        $set('slug', Str::slug((string)$state));
                                    }
                                })
                                ->required(fn() => $locale === $locales[0]),

                            TextInput::make("translations.{$locale}.title")
                                ->label(__('pages::admin.title')),

                            Builder::make("translations.{$locale}.content")
                                ->label(__('pages::admin.content'))
                                ->blocks(PageBlocks::all())
                                ->columnSpanFull()
                                ->collapsible()
                                ->collapsed()
                                ->cloneable()
                        ])->columns(2);
                })->toArray()
            )->columnSpanFull();
    }
}
