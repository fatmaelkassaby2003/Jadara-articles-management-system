<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/articles', [WebArticleController::class, 'index'])->name('web.articles.index');
Route::get('/articles/{slug}', [WebArticleController::class, 'show'])->name('web.articles.show');
