<?php

namespace App\Actions;

use App\Models\Article;
use Illuminate\Support\Str;

class StoreArticleAction
{
    public function __invoke(array $data): Article
    {
        $article = new Article($data);
        $article->user()->associate(auth()->user());
        $article->save();

        return $article;
    }
}
