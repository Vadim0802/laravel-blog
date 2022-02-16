<?php

namespace App\Http\Controllers;

use App\Actions\StoreArticleLikeAction;
use App\Models\Article;
use App\Models\ArticleLike;

class ArticleLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function index(Article $article)
    {
        return view('article_likes.index', [
            'likes' => $article->likes()->latest()->paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Article $article, StoreArticleLikeAction $action)
    {
        $this->authorize('create', ArticleLike::class);
        $action($article);

        return to_route('articles.show', $article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @param  \App\Models\ArticleLike  $like
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article, ArticleLike $like)
    {
        $this->authorize('delete', $like);
        $like->delete();
        $article->update(['likes_count' => $article->likes_count - 1]);

        return to_route('articles.show', $article);
    }
}
