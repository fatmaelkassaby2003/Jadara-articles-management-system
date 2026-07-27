<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Article $article): bool
    {
        if ($article->status === Article::STATUS_PUBLISHED) {
            return true;
        }

        return $user && $user->id === $article->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Article $article): bool
    {
        if (request()->is('api/*')) {
            return $user->id === $article->user_id;
        }

        return true;
    }

    public function delete(User $user, Article $article): bool
    {
        if (request()->is('api/*')) {
            return $user->id === $article->user_id;
        }

        return true;
    }

    public function restore(User $user, Article $article): bool
    {
        if (request()->is('api/*')) {
            return $user->id === $article->user_id;
        }

        return true;
    }

    public function forceDelete(User $user, Article $article): bool
    {
        if (request()->is('api/*')) {
            return $user->id === $article->user_id;
        }

        return true;
    }
}
