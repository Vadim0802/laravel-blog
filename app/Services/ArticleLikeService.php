<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleLike;

class ArticleLikeService
{
    public function getLikes(Article $article, int $paginate = 10)
    {
        $likes = $article->likes()->with('user')->latest()->paginate($paginate);

        return $likes;
    }

    public function storeNewLike(Article $article)
    {
        if ($this->likeAlreadyExists($article)) {
            throw new \Exception("Like already exist");
        }

        $like = new ArticleLike();
        $like->user()->associate(auth()->user());
        $like->article()->associate($article);
        $like->save();

        $article->update(['likes_count' => $this->increaseLikeCount($article)]);

        return $like;
    }

    public function deleteLike(Article $article, ArticleLike $like)
    {
        $like->delete();
        $article->update(['likes_count' => $this->decreaseLikesCount($article)]);

        return $article;
    }

    private function decreaseLikesCount(Article $article)
    {
        return $article->likes_count - 1;
    }

    private function increaseLikeCount(Article $article)
    {
        return $article->likes_count + 1;
    }

    private function likeAlreadyExists($article)
    {
        return $article->likes->pluck('user_id')->contains(auth()->id());
    }
}
