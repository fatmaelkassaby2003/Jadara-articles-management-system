<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_article(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/articles', [
            'title' => 'مقال تجريبي جديد',
            'category_id' => $category->id,
            'content' => 'محتوى المقال التجريبي بالتفصيل.',
            'status' => 'published',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'مقال تجريبي جديد');

        $this->assertDatabaseHas('articles', ['title' => 'مقال تجريبي جديد']);
    }

    public function test_user_cannot_update_others_article(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2, 'sanctum')->putJson("/api/v1/articles/{$article->id}", [
            'title' => 'عنوان معدل غير مصرح به',
        ]);

        $response->assertStatus(403);
    }
}
