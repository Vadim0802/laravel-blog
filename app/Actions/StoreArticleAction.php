<?php

namespace App\Actions;

use App\Models\Article;

class StoreArticleAction
{
    public function handle(array $data)
    {
        $article = new Article($data);
        $article->user()->associate(auth()->user());
        $article->save();
    }
}
