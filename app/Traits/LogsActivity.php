<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            static::logAction($model, 'created');
        });

        static::updated(function ($model) {
            static::logAction($model, 'updated', $model->getChanges());
        });

        static::deleted(function ($model) {
            static::logAction($model, 'deleted');
        });
    }

    protected static function logAction($model, string $action, array $changes = []): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'changes' => !empty($changes) ? $changes : null,
        ]);
    }
}
