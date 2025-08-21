<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Gigabait93\FilamentPages\Resources\Pages\PageResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    public function getTitle(): string
    {
        return __('pages::admin.edit');
    }

    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),

            Action::make('cloneLocale')
                ->label(__('pages::admin.clone_locale'))
                ->icon('heroicon-m-language')
                ->schema(function () {
                    $locales = localesOptions();

                    return [
                        Select::make('from')
                            ->label(__('pages::admin.from_locale'))
                            ->options(array_combine($locales, $locales))
                            ->required()
                            ->native(false),

                        Select::make('to')
                            ->label(__('pages::admin.to_locale'))
                            ->options(array_combine($locales, $locales))
                            ->required()
                            ->native(false),

                        Toggle::make('overwrite')
                            ->label(__('pages::admin.overwrite_if_exists'))
                            ->default(false),
                    ];
                })
                ->action(function (array $data) {
                    $this->cloneLocale(
                        from: (string)$data['from'],
                        to: (string)$data['to'],
                        overwrite: (bool)($data['overwrite'] ?? false),
                    );

                    Notification::make('cloneLocale')
                        ->success()
                        ->title(__('pages::admin.locale_cloned'))
                        ->body(__('pages::admin.locale_cloned_body', [
                            'from' => $data['from'],
                            'to' => $data['to'],
                        ]))
                        ->send();
                    $this->fillForm();
                }),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['translations'] = [];
        foreach ($this->record->translations as $trans) {
            $locale = $trans->locale;
            $transArray = $trans->toArray();
            unset($transArray['id'], $transArray['page_id'], $transArray['locale']);
            $data['translations'][$locale] = $transArray;
        }
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $translationsData = $data['translations'] ?? [];
        unset($data['translations']);

        $data['updated_by'] = auth()->id();
        $record->update($data);

        foreach ($translationsData as $locale => $transData) {
            if (!filled($transData['name'] ?? null)) {
                continue;
            }

            $payload = [
                'locale' => $locale,
                'name' => $transData['name'],
                'title' => $transData['title'] ?? null,
                'content' => $transData['content'] ?? null,
                'content_html' => $transData['content_html'] ?? null,
            ];

            $translation = $record->translations()->firstWhere('locale', $locale);
            $translation ? $translation->update($payload) : $record->translations()->create($payload);
        }

        return $record;
    }

    protected function cloneLocale(string $from, string $to, bool $overwrite = false): void
    {
        if ($from === $to) {
            return;
        }

        $src = $this->record->translations()->firstWhere('locale', $from);
        if (!$src) {
            return;
        }

        $dst = $this->record->translations()->firstWhere('locale', $to);

        $payload = Arr::only($src->toArray(), ['title', 'name', 'content', 'content_html']);
        $payload['locale'] = $to;

        if ($dst) {
            if (!$overwrite) {
                return;
            }
            $dst->update($payload);
        } else {
            $this->record->translations()->create($payload);
        }
    }

}

