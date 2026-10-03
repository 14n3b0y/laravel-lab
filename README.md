# Лабораторная работа: Laravel

**Тема:** Обзор PHP-фреймворков и паттернов программирования.

**Студент:** Кузнецов Никита, группа 14321-ЗБ (ПИ)

## Что это

Учебный проект на Laravel 13 — мини-CRUD для статей. Реализованы все
пять пунктов задания: роутинг, модели и миграции, приём и валидация
POST-формы, сессии, события и слушатели.

## Стек

- PHP 8.5
- Laravel 13.33
- SQLite
- Composer 2.10
- Git

## Как запустить локально

    git clone https://github.com/14n3b0y/laravel-lab.git
    cd laravel-lab
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan serve

После этого проект доступен по адресу http://127.0.0.1:8000.

## Реализация по пунктам задания

### 1. Роутинг, контроллеры, шаблоны

- **Роуты:** `routes/web.php` — три маршрута:
  - `GET /articles` — список статей
  - `GET /articles/create` — форма создания
  - `POST /articles` — приём формы
- **Контроллер:** `app/Http/Controllers/ArticleController.php` —
  методы `index`, `create`, `store`.
- **Шаблоны:** `resources/views/articles/index.blade.php` и
  `resources/views/articles/create.blade.php` (Blade).

### 2. Модели и миграции

- **Модель:** `app/Models/Article.php`. Наследует
  `Illuminate\Database\Eloquent\Model`, поле
  `$fillable = ['title', 'body']` разрешает массовое заполнение.
- **Миграция:**
  `database/migrations/2026_09_25_112547_create_articles_table.php`.
  Создаёт таблицу `articles` с колонками `id`, `title`, `body`,
  `created_at`, `updated_at`.
- Применяется командой `php artisan migrate`.

### 3. Приём и валидация данных из формы (POST)

- Форма в `resources/views/articles/create.blade.php` использует
  `method="POST"` и директиву `@csrf` (защита от CSRF-атак).
- Валидация — в `ArticleController::store()` через `$request->validate()`:
  - `title` — обязательное, максимум 255 символов
  - `body` — обязательное
- При провале валидации Laravel автоматически возвращает пользователя
  на форму, ошибки выводятся через директиву `@error`.

### 4. Работа с сессиями

- Flash-сообщение пишется в сессию в контроллере:
  `$request->session()->flash('status', 'Статья успешно создана')`.
- Читается в `index.blade.php` через `session('status')`.
- Flash-сообщение живёт один следующий запрос: показывается после
  редиректа и исчезает после обновления страницы.

### 5. Создание и обработка событий

- **Событие:** `app/Events/ArticleCreated.php` — принимает модель
  `Article` в конструктор.
- **Слушатель:** `app/Listeners/LogArticleCreated.php` — пишет в лог
  заголовок созданной статьи.
- **Запуск:** в `ArticleController::store()` после создания записи
  вызывается `event(new ArticleCreated($article))`.
- **Проверка:** после создания статьи в `storage/logs/laravel.log`
  появляется строка вида
  `[2026-09-25 11:41:07] local.INFO: Статья создана: Название статьи`.

Здесь применён **паттерн «Наблюдатель» (Observer)** — контроллер
не знает, кто и как реагирует на событие, он только сигнализирует
о факте. В реальном проекте на это же событие можно навесить отправку
email, обновление кеша, уведомления — не трогая контроллер.

## Структура ключевых файлов

    app/
    ├── Events/ArticleCreated.php
    ├── Http/Controllers/ArticleController.php
    ├── Listeners/LogArticleCreated.php
    └── Models/Article.php
    database/migrations/2026_09_25_112547_create_articles_table.php
    resources/views/articles/
    ├── index.blade.php
    └── create.blade.php
    routes/web.php

## Проверка работоспособности

1. Открыть http://127.0.0.1:8000/articles — список статей.
2. Нажать «Создать статью», отправить пустую форму — появятся ошибки
   валидации.
3. Заполнить поля и отправить — редирект на список с зелёным
   flash-сообщением.
4. Обновить страницу — сообщение исчезнет (сессия работает как flash).
5. Открыть storage/logs/laravel.log — там будет запись от события.