@extends('layouts.app')

@section('title', 'جميع المقالات')

@section('content')
    <h1 class="text-3xl font-bold mb-6">📚 جميع المقالات</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($articles as $article)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <span class="text-xs bg-indigo-50 text-indigo-600 font-bold px-3 py-1 rounded-full">{{ $article->category->name }}</span>
                <h3 class="text-xl font-bold mt-3 mb-2">
                    <a href="{{ route('web.articles.show', $article->slug) }}" class="hover:text-indigo-600">{{ $article->title }}</a>
                </h3>
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($article->excerpt, 100) }}</p>
                <div class="flex justify-between text-xs text-gray-400">
                    <span>👤 {{ $article->user->name }}</span>
                    <span>👁️ {{ $article->views_count }} مشاهدة</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $articles->links() }}
    </div>
@endsection
