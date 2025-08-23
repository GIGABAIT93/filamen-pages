<?php

namespace Gigabait93\FilamentPages\Pages;

use Filament\Pages\Page as FilamentPage;
use Filament\Panel;
use Gigabait93\FilamentPages\Models\Page;
use Gigabait93\FilamentPages\Models\PageTranslation;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Show extends FilamentPage
{
    protected string $view = 'pages::show';
    protected static ?string $slug = 'p/{slug?}';
    protected static bool $shouldRegisterNavigation = false;
    private array $blocks;
    private ?PageTranslation $tr = null;

    public static function getWithoutRouteMiddleware(Panel $panel): array
    {
        return array_merge($panel->getAuthMiddleware(), [$panel->getEmailVerifiedMiddleware()]);
    }

    public function mount(string $slug): void
    {
        $page = Page::query()->where('slug', $slug)->first();
        if (!$page) $this->abortNotFound('Page not found.');


        if (!$page->is_active) $this->abortNotFound('Page is inactive.');
        if (!$page->canVisibility()) $this->abortForbidden('Permission denied to view this page.');


        $tr = $page->translation();
        if (!$tr) $this->abortNotFound('Page content not found.');


        $this->tr = $tr;
        $this->maxContentWidth = $page->page_width ?? null;

        $this->blocks = page_normalize_blocks($tr->content);
    }

    public function getTitle(): string
    {
        return $this->tr->title ?? __('pages::admin.pages');
    }

    public function getViewData(): array
    {
        return ['blocks' => $this->blocks];
    }

    private function abortNotFound(string $message = 'Not Found'): never
    {
        throw new NotFoundHttpException($message);
    }

    private function abortForbidden(string $message = 'Forbidden'): never
    {
        throw new HttpException(403, $message);
    }
}
