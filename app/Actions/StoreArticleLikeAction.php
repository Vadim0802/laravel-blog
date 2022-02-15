<?php

namespace App\Actions;

use App\Models\Article;
use App\Models\ArticleLike;

class StoreArticleLikeAction
{
    public function handle(Article $article)
    {
        if ($article->likes->pluck('user_id')->contains(auth()->id())) {
            return false;
        }

        $like = new ArticleLike();
        $like->user()->associate(auth()->user());
        $like->article()->associate($article);
        $like->save();

        $article->update(['likes_count' => $article->likes_count + 1]);

        return $like;
    }
}
