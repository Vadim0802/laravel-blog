<?php

namespace App\Actions;

use App\Models\Article;
use Illuminate\Support\Str;

class StoreArticleAction
{
    public function __invoke(array $data): Article
    {
        $article = new Article($data);
        $article->author()->associate(auth()->user());
        $article->save();

        foreach ($data['tags'] as $tag) {
            $article->tags()->attach($tag);
        }

        return $article;
    }
}
