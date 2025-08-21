<?php

namespace Gigabait93\FilamentPages\Resources\Pages\Pages;

use Filament\Resources\Pages\CreateRecord;
use Gigabait93\FilamentPages\Models\Page;
use Gigabait93\FilamentPages\Resources\Pages\PageResource;
use Illuminate\Database\Eloquent\Model;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    public function getTitle(): string
    {
        return __('pages::admin.create_page');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $translationsData = $data['translations'] ?? [];

        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();
        unset($data['translations']);

        /** @var Page $page */
        $page = static::getModel()::create($data);

        foreach ($translationsData as $locale => $transData) {
            if (!filled($transData['name'] ?? null)) {
                continue;
            }

            $page->translations()->create([
                'locale' => $locale,
                'name' => $transData['name'],
                'title' => $transData['title'] ?? null,
                'content' => $transData['content'] ?? null,
                'content_html' => $transData['content_html'] ?? null,
            ]);
        }

        return $page;
    }
}


