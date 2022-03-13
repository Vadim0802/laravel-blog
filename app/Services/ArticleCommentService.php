<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleComment;

class ArticleCommentService
{
    public function storeNewComment(string $content, Article $article)
    {
        $comment = new ArticleComment([
            'content' => $content
        ]);
        $comment->user()->associate(auth()->user());
        $comment->article()->associate($article);
        $comment->save();

        return $comment;
    }

    public function updateComment(string $content, ArticleComment $comment)
    {
        $comment->update(['content' => $content]);

        return $comment;
    }

    public function deleteComment(ArticleComment $comment)
    {
        $comment->delete();

        return $comment;
    }
}
