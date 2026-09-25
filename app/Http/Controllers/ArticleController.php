<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Events\ArticleCreated;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Список всех статей
    public function index()
    {
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    // Форма создания статьи
    public function create()
    {
        return view('articles.create');
    }

    // Принять данные и сохранить
    public function store(Request $request)
    {
        // Валидация
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body'  => 'required',
        ]);

        // Создание записи в БД
        $article = Article::create($validated);

        // Запуск события
        event(new ArticleCreated($article));

        // Flash-сообщение в сессию
        $request->session()->flash('status', 'Статья успешно создана');

        // Редирект на список статей
        return redirect()->route('articles.index');
    }
}