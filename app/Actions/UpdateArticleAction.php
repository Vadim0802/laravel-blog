<?php

namespace App\Actions;

use App\Models\Article;

class UpdateArticleAction
{
    public function __invoke(array $data, Article $article)
    {
        $article->update($data);

        $article->tags()->detach();
        foreach ($data['tags'] as $tag) {
            $article->tags()->attach($tag);
        }

        return $article;
    }
}
