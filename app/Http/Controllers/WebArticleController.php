<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WebArticleController extends Controller
{
    public function __construct(protected ArticleService $articleService) {}

    public function index(Request $request): View
    {
        $articles = $this->articleService->getArticlesList($request->all());
        $categories = Category::all();

        return view('articles.index', compact('articles', 'categories'));
    }

    public function show(string $slug): View
    {
        $data = $this->articleService->getArticleDetails($slug);
        return view('articles.show', [
            'article' => $data['article'],
            'related' => $data['related'],
        ]);
    }
}
