<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use App\Services\ArticleLikeService;

class ArticleLikeController extends Controller
{
    public function index(Article $article, ArticleLikeService $articleLikeService)
    {
        $likes = $articleLikeService->getLikes($article);

        return view('article_likes.index', compact('likes'));
    }

    public function store(Article $article, ArticleLikeService $articleLikeService)
    {
        $this->authorize('create', ArticleLike::class);

        $articleLikeService->storeNewLike($article);

        return to_route('articles.show', $article);
    }

    public function destroy(Article $article, ArticleLike $like, ArticleLikeService $articleLikeService)
    {
        $this->authorize('delete', $like);

        $articleLikeService->deleteLike($article, $like);

        return to_route('articles.show', $article);
    }
}
