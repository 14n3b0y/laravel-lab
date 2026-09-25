<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;  // <-- добавь

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'Привет, это мой первый роут!';
});

// Роуты для статей
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');