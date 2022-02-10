<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Http\Request;

class ArticleCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Article $article)
    {
        $data = $request->validate([
            'content' => 'required|max:255'
        ]);

        $comment = new ArticleComment($data);
        $comment->user()->associate(auth()->user());
        $article->comments()->save($comment);

        return redirect()
            ->route('articles.show', $article)
            ->with('success', 'Comment successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @param  \App\Models\ArticleComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article, ArticleComment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @param  \App\Models\ArticleComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article, ArticleComment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @param  \App\Models\ArticleComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article, ArticleComment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @param  \App\Models\ArticleComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article, ArticleComment $comment)
    {
        //
    }
}
