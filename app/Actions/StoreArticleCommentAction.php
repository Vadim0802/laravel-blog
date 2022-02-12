<?php

namespace App\Actions;

use App\Models\Article;
use App\Models\ArticleComment;

class StoreArticleCommentAction
{
    public function handle(array $data, Article $article)
    {
        $comment = new ArticleComment($data);
        $comment->user()->associate(auth()->user());
        $comment->article()->associate($article);
        $comment->save();

        return $comment;
    }
}
