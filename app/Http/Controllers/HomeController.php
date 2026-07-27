<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $latestArticles = Article::with(['user', 'category'])
            ->published()
            ->latest()
            ->take(6)
            ->get();

        $popularArticles = Article::with(['user', 'category'])
            ->published()
            ->popular()
            ->take(4)
            ->get();

        $categories = Category::withCount('articles')->get();

        return view('home', compact('latestArticles', 'popularArticles', 'categories'));
    }
}
