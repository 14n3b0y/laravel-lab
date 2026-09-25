<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список статей</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; }
        article { border-bottom: 1px solid #ccc; padding: 15px 0; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; }
        a { color: #333; }
    </style>
</head>
<body>
    <h1>Статьи</h1>

    {{-- Flash-сообщение из сессии --}}
    @if (session('status'))
        <div class="success">{{ session('status') }}</div>
    @endif

    {{-- Цикл по статьям --}}
    @forelse ($articles as $article)
        <article>
            <h2>{{ $article->title }}</h2>
            <p>{{ $article->body }}</p>
        </article>
    @empty
        <p>Статей пока нет. Создай первую!</p>
    @endforelse

    <p><a href="{{ route('articles.create') }}">Создать статью</a></p>
</body>
</html>