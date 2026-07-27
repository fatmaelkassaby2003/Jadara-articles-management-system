@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <article class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 max-w-4xl mx-auto">
        <span class="text-sm bg-indigo-50 text-indigo-600 font-bold px-4 py-1.5 rounded-full">{{ $article->category->name }}</span>
        <h1 class="text-4xl font-bold mt-4 mb-4 text-gray-900">{{ $article->title }}</h1>

        <div class="flex items-center gap-6 text-sm text-gray-500 mb-8 border-b pb-4">
            <span>👤 الكاتب: <strong>{{ $article->user->name }}</strong></span>
            <span>📅 {{ $article->created_at->format('Y-m-d') }}</span>
            <span>⏱️ {{ $article->reading_time }} دقيقة قراءة</span>
            <span>👁️ {{ $article->views_count }} مشاهدة</span>
        </div>

        <div class="prose max-w-none text-gray-700 leading-relaxed mb-8">
            {!! nl2br(e($article->content)) !!}
        </div>
    </article>
@endsection
