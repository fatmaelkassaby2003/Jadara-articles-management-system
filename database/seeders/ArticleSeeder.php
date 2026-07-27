<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id');
        $categoryIds = Category::pluck('id');
        $tagIds = Tag::pluck('id');

        Article::factory()
            ->count(150)
            ->create([
                'user_id' => fn () => $userIds->random(),
                'category_id' => fn () => $categoryIds->random(),
            ])
            ->each(function (Article $article) use ($tagIds) {
                $article->tags()->attach(
                    $tagIds->random(fake()->numberBetween(1, 4))
                );
            });
    }
}