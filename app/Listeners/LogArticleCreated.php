<?php

namespace App\Listeners;

use App\Events\ArticleCreated;
use Illuminate\Support\Facades\Log;

class LogArticleCreated
{
    public function handle(ArticleCreated $event): void
    {
        Log::info('Статья создана: ' . $event->article->title);
    }
}