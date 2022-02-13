<?php

namespace App\Http\Controllers;

use App\Actions\StoreArticleCommentAction;
use App\Http\Requests\StoreArticleCommentRequest;
use App\Http\Requests\UpdateArticleCommentRequest;
use App\Models\Article;
use App\Models\ArticleComment;

class ArticleCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreArticleCommentRequest $request, Article $article, StoreArticleCommentAction $action)
    {
        $action->handle($request->validated(), $article);

        return redirect()->route('articles.show', $article)->with('success', 'Comment successfully created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @param  \App\Models\ArticleComment  $comment
     * @return \Illuminate\View\View
     */
    public function edit(Article $article, ArticleComment $comment)
    {
        return view('article_comments.edit', compact('article', 'comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @param  \App\Models\ArticleComment  $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateArticleCommentRequest $request, Article $article, ArticleComment $comment)
    {
        $comment->update($request->validated());

        return redirect()->route('articles.show', $article)->with('success', 'Your comment successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @param  \App\Models\ArticleComment  $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article, ArticleComment $comment)
    {
        $comment->delete();

        return redirect()->route('articles.show', $article)->with('success', 'Your comment successfully deleted!');
    }
}
