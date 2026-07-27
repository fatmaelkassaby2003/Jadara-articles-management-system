<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::withCount('articles')->get();
        return CategoryResource::collection($categories);
    }

    public function show(string $slug): CategoryResource
    {
        $category = Category::where('slug', $slug)->withCount('articles')->firstOrFail();
        return new CategoryResource($category);
    }
}
