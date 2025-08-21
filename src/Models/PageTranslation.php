<?php

namespace Gigabait93\FilamentPages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $page_id
 * @property string $locale
 * @property string $name
 * @property string|null $title
 * @property array|null $content
 * @property string|null $content_html
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property array|null $meta_keywords
 * @property-read Page $page
 * @property-read string $seo_title
 * @property-read string|null $seo_description
 */
class PageTranslation extends Model
{
    protected $fillable = [
        'page_id', 'locale', 'name', 'title', 'content', 'content_html'
    ];

    protected $casts = [
        'content' => 'array',
        'meta_keywords' => 'array',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: $this->title;
    }

    public function getSeoDescriptionAttribute(): ?string
    {
        return $this->meta_description ?: null;
    }
}
