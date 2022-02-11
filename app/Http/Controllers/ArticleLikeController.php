<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use Illuminate\Http\Request;

class ArticleLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function index(Article $article)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function create(Article $article)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Article $article)
    {
        if (! $article->likes->pluck('user_id')->contains(auth()->id())) {
            $like = new ArticleLike();
            $like->user()->associate(auth()->user());
            $like->article()->associate($article);
            $like->save();
        }

        return redirect()->route('articles.show', $article);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @param  \App\Models\ArticleLike  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article, ArticleLike $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @param  \App\Models\ArticleLike  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article, ArticleLike $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @param  \App\Models\ArticleLike  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article, ArticleLike $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @param  \App\Models\ArticleLike  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article, ArticleLike $like)
    {
        $like->delete();

        return redirect()
            ->route('articles.show', $article);
    }
}
