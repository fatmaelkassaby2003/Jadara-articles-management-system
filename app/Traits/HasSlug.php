<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->title ?? $model->name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('title') || $model->isDirty('name')) {
                $model->slug = static::generateUniqueSlug($model->title ?? $model->name, $model->id);
            }
        });
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title, '-', 'ar');
        if (empty($slug)) {
            $slug = Str::slug($title);
        }
        if (empty($slug)) {
            $slug = 'item-' . time();
        }

        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
