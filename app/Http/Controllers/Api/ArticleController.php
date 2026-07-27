<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\Api\ArticleResource;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    public function __construct(protected ArticleService $articleService) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $articles = $this->articleService->getArticlesList($request->all());
        return ArticleResource::collection($articles);
    }

    public function show(string $slug): JsonResponse
    {
        $data = $this->articleService->getArticleDetails($slug);
        return response()->json([
            'data' => new ArticleResource($data['article']),
            'related' => ArticleResource::collection($data['related']),
        ]);
    }

    public function store(StoreArticleRequest $request): JsonResponse
    {
        $article = $this->articleService->createArticle($request->validated(), $request->user()->id);
        return response()->json([
            'message' => 'تم إنشاء المقال بنجاح',
            'data' => new ArticleResource($article),
        ], 201);
    }

    public function update(UpdateArticleRequest $request, Article $article): JsonResponse
    {
        $updated = $this->articleService->updateArticle($article, $request->validated());
        return response()->json([
            'message' => 'تم تعديل المقال بنجاح',
            'data' => new ArticleResource($updated),
        ]);
    }

    public function destroy(Article $article): JsonResponse
    {
        $this->authorize('delete', $article);
        $this->articleService->deleteArticle($article);

        return response()->json(['message' => 'تم حذف المقال بنجاح']);
    }

    public function popular(): AnonymousResourceCollection
    {
        $articles = $this->articleService->getPopularArticles();
        return ArticleResource::collection($articles);
    }
}
