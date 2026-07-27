<?php

namespace App\Models;

use App\Traits\CalculatesReadingTime;
use App\Traits\LogsActivity;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes, HasSlug, CalculatesReadingTime, LogsActivity;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'status',
        'reading_time',
        'views_count',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'views_count' => 'integer',
            'reading_time' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    // Local Scopes
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->orderBy('views_count', 'desc');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when($term, function ($q) use ($term) {
            $q->where(function ($sub) use ($term) {
                $sub->where('title', 'like', "%{$term}%")
                    ->orWhere('excerpt', 'like', "%{$term}%")
                    ->orWhere('content', 'like', "%{$term}%");
            });
        });
    }

    public function scopeFilterByCategory(Builder $query, ?string $categorySlug): Builder
    {
        return $query->when($categorySlug, function ($q) use ($categorySlug) {
            $q->whereHas('category', fn($c) => $c->where('slug', $categorySlug));
        });
    }

    public function scopeFilterByTag(Builder $query, ?string $tagSlug): Builder
    {
        return $query->when($tagSlug, function ($q) use ($tagSlug) {
            $q->whereHas('tags', fn($t) => $t->where('slug', $tagSlug));
        });
    }

    public function scopeSortBy(Builder $query, ?string $sort = 'latest'): Builder
    {
        return match ($sort) {
            'popular' => $query->orderBy('views_count', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };
    }
}
