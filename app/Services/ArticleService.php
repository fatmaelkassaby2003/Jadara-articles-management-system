<?php

namespace App\Services;

use App\Events\ArticleViewed;
use App\Notifications\ArticlePublishedNotification;
use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ArticleService
{
    public function getArticlesList(array $filters): LengthAwarePaginator
    {
        return Article::with(['user', 'category', 'tags'])
            ->published()
            ->search($filters['search'] ?? null)
            ->filterByCategory($filters['category'] ?? null)
            ->filterByTag($filters['tag'] ?? null)
            ->sortBy($filters['sort'] ?? 'latest')
            ->paginate($filters['per_page'] ?? 9);
    }

    
    public function getArticleDetails(string $slug): array
    {
        $article = Article::with(['user', 'category', 'tags'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        event(new ArticleViewed($article));

        $relatedArticles = Cache::remember("article_{$article->id}_related", 3600, function () use ($article) {
            return Article::published()
                ->where('category_id', $article->category_id)
                ->where('id', '!=', $article->id)
                ->take(3)
                ->get();
        });

        return [
            'article' => $article,
            'related' => $relatedArticles,
        ];
    }

    
    public function createArticle(array $data, int $userId): Article
    {
        $data['user_id'] = $userId;

        if (isset($data['cover_image']) && $data['cover_image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['cover_image'] = $data['cover_image']->store('articles', 'public');
        }

        if (($data['status'] ?? null) === Article::STATUS_PUBLISHED) {
            $data['published_at'] = now();
        }

        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $article = Article::create($data);

        if (!empty($tags)) {
            $article->tags()->sync($tags);
        }

        Cache::forget('popular_articles');

        if ($article->status === Article::STATUS_PUBLISHED) {
            $article->user->notify(new ArticlePublishedNotification($article));
        }

        return $article->load(['user', 'category', 'tags']);
    }

   
    public function updateArticle(Article $article, array $data): Article
    {
        if (isset($data['cover_image']) && $data['cover_image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($article->cover_image) {
                Storage::disk('public')->delete($article->cover_image);
            }
            $data['cover_image'] = $data['cover_image']->store('articles', 'public');
        }

        if (($data['status'] ?? null) === Article::STATUS_PUBLISHED && !$article->published_at) {
            $data['published_at'] = now();
        }

        if (isset($data['tags'])) {
            $article->tags()->sync($data['tags']);
            unset($data['tags']);
        }

        $article->update($data);

        Cache::forget('popular_articles');

        return $article->fresh(['user', 'category', 'tags']);
    }

   
    public function deleteArticle(Article $article): bool
    {
        Cache::forget('popular_articles');
        return (bool) $article->delete();
    }

   
    public function getPopularArticles(int $limit = 5): Collection
    {
        return Cache::remember("popular_articles_{$limit}", 3600, function () use ($limit) {
            return Article::with(['category', 'user'])
                ->published()
                ->popular()
                ->take($limit)
                ->get();
        });
    }

    
    public function incrementViews(Article $article): void
    {
        $article->increment('views_count');
    }
}
