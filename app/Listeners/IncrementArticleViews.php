<?php

namespace App\Listeners;

use App\Events\ArticleViewed;
use App\Services\ArticleService;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncrementArticleViews implements ShouldQueue
{
    public function __construct(protected ArticleService $articleService) {}

    public function handle(ArticleViewed $event): void
    {
        $this->articleService->incrementViews($event->article);
    }
}
