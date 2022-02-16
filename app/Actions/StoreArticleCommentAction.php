<?php

namespace App\Actions;

use App\Models\Article;
use App\Models\ArticleComment;

class StoreArticleCommentAction
{
    public function __invoke(array $data, Article $article): ArticleComment
    {
        $comment = new ArticleComment($data);
        $comment->user()->associate(auth()->user());
        $comment->article()->associate($article);
        $comment->save();

        return $comment;
    }
}
