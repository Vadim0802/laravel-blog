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
        $likes = $article->likes()->orderBy('id', 'desc')->paginate(10);

        return view('article_likes.index', compact('likes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Article $article, StoreArticleLikeAction $action)
    {
        $action->handle($article);

        return redirect()->route('articles.show', $article);
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
        $like->delete();

        return redirect()->route('articles.show', $article);
    }
}
