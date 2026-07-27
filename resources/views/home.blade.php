@extends('layouts.app')

@section('title', 'الرئيسية - منصة المقالات')

@section('content')
    <!-- Hero Search Section -->
    <div class="bg-indigo-600 text-white rounded-2xl p-8 mb-12 text-center shadow-lg">
        <h1 class="text-4xl font-bold mb-4">ابحث عن أرقى المقالات والأفكار</h1>
        <p class="text-indigo-100 mb-6">اكتشف المعرفة والمقالات في مختلف المجالات</p>
        <form action="{{ route('web.articles.index') }}" method="GET" class="max-w-xl mx-auto flex gap-2">
            <input type="text" name="search" placeholder="ابحث عن عنوان أو كلمة مفتاحية..." class="w-full px-4 py-3 rounded-xl text-gray-800 focus:outline-none">
            <button type="submit" class="bg-gray-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-800">بحث</button>
        </form>
    </div>

    <!-- Latest Articles -->
    <h2 class="text-2xl font-bold mb-6 text-gray-900">✨ أحدث المقالات</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        @foreach($latestArticles as $article)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                <div class="p-6">
                    <span class="text-xs bg-indigo-50 text-indigo-600 font-bold px-3 py-1 rounded-full">{{ $article->category->name }}</span>
                    <h3 class="text-xl font-bold mt-3 mb-2 text-gray-900">
                        <a href="{{ route('web.articles.show', $article->slug) }}" class="hover:text-indigo-600">{{ $article->title }}</a>
                    </h3>
                    <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ $article->excerpt }}</p>
                    <div class="flex justify-between items-center text-xs text-gray-400">
                        <span>👤 {{ $article->user->name }}</span>
                        <span>⏱️ {{ $article->reading_time }} د قراءة</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
