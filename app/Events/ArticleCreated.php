<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticleCreated
{
    use Dispatchable, SerializesModels;

    // Публичное свойство — данные, которые событие передаёт слушателям
    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }
}