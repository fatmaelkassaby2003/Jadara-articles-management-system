<?php

namespace App\Traits;

trait CalculatesReadingTime
{
    protected static function bootCalculatesReadingTime(): void
    {
        static::saving(function ($model) {
            if (isset($model->content)) {
                $plainText = strip_tags($model->content);
                $wordCount = str_word_count($plainText);
                if ($wordCount === 0) {
                    $wordCount = (int) ceil(mb_strlen($plainText) / 5);
                }
                $model->reading_time = (int) max(1, ceil($wordCount / 200));
            }
        });
    }
}
