<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);
        $content = fake()->paragraphs(8, true);
        $isPublished = fake()->boolean(70); // 70% من المقالات published

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 100000),
            'excerpt' => fake()->sentence(20),
            'content' => $content,
            'cover_image' => null,
            'status' => $isPublished ? Article::STATUS_PUBLISHED : Article::STATUS_DRAFT,
            'reading_time' => max(1, intdiv(str_word_count($content), 200)), // متوسط قراءة 200 كلمة/دقيقة
            'views_count' => $isPublished ? fake()->numberBetween(0, 5000) : 0,
            'published_at' => $isPublished ? fake()->dateTimeBetween('-6 months', 'now') : null,
        ];
    }
}