<?php

namespace Gigabait93\FilamentPages\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $slug
 * @property string|null $template
 * @property string|null $nav_icon
 * @property string|null $nav_group
 * @property bool $nav_blank
 * @property string|null $page_width
 * @property bool $is_active
 * @property string $visibility
 * @property int $position
 * @property Carbon|null $published_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read Collection<int, PageTranslation> $translations
 */
class Page extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'template', 'nav_icon', 'nav_group', 'nav_blank',
        'page_width', 'is_active', 'visibility',
        'position', 'published_at', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'is_active' => 'bool',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            $model->slug = Str::slug($model->slug);
        });
    }

    private function getUserClass()
    {
        return config('pages.user_model', 'App\Models\User::class');

    }

    // ── Relations ─────────────────────────────────────────────────────────────
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo($this->getUserClass(), 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo($this->getUserClass(), 'updated_by');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function translation(?string $locale = null): ?PageTranslation
    {
        $locale = $locale ?: auth()->user()->language ?? app()->getLocale();

        return $this->translations
            ->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', config('app.fallback_locale'))
            ?? $this->translations->first();
    }

    // ── Scopes ────────────────────────────────────────────────────────────────
    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeVisibleFor(Builder $q, ?Authenticatable $user): Builder
    {
        return $q->where(function (Builder $qq) use ($user) {
            $qq->where('visibility', 'public')
                ->when($user, fn($q2) => $q2->orWhere('visibility', 'auth'));
        });
    }

    public function canVisibility(): bool
    {
        if ($this->visibility === 'auth') {
            return auth()->check();
        }

        if ($this->visibility === 'private') {
            return auth()->check() && auth()->id() === $this->created_by;
        }

        return $this->visibility === 'public';
    }
}
