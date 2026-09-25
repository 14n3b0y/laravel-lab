<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создать статью</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; }
        .error { color: red; font-size: 14px; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; box-sizing: border-box; }
        button { padding: 10px 20px; background: #333; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Создать статью</h1>

    <form method="POST" action="{{ route('articles.store') }}">
        @csrf

        <div>
            <label>Заголовок</label>
            <input type="text" name="title" value="{{ old('title') }}">
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Текст</label>
            <textarea name="body" rows="6">{{ old('body') }}</textarea>
            @error('body')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Сохранить</button>
    </form>

    <p><a href="{{ route('articles.index') }}">Назад к списку</a></p>
</body>
</html>