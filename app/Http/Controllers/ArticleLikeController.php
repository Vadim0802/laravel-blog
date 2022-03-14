<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use App\Services\ArticleLikeService;

class ArticleLikeController extends Controller
{
    private ArticleLikeService $likeService;

    public function __construct(ArticleLikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function index(Article $article)
    {
        $likes = $this->likeService->getLikes($article);

        return view('article_likes.index', compact('likes'));
    }

    public function store(Article $article)
    {
        $this->authorize('create', ArticleLike::class);

        $this->likeService->storeNewLike($article);

        return to_route('articles.show', $article);
    }

    public function destroy(Article $article, ArticleLike $like)
    {
        $this->authorize('delete', $like);

        $this->likeService->deleteLike($article, $like);

        return to_route('articles.show', $article);
    }
}
