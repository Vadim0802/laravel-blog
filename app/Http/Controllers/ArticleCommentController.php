<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleCommentRequest;
use App\Http\Requests\UpdateArticleCommentRequest;
use App\Models\Article;
use App\Models\ArticleComment;
use App\Services\ArticleCommentService;

class ArticleCommentController extends Controller
{
    private ArticleCommentService $commentService;

    public function __construct(ArticleCommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(StoreArticleCommentRequest $request, Article $article)
    {
        $this->commentService->storeNewComment($request->content, $article);

        return to_route('articles.show', $article)
            ->with('success', 'Comment successfully created!');
    }

    public function edit(Article $article, ArticleComment $comment)
    {
        return view('article_comments.edit', compact('article', 'comment'));
    }

    public function update(
        UpdateArticleCommentRequest $request,
        Article $article,
        ArticleComment $comment,
    ) {
        $this->commentService->updateComment($request->content, $comment);

        return to_route('articles.show', $article)
            ->with('success', 'Your comment successfully updated!');
    }

    public function destroy(Article $article, ArticleComment $comment)
    {
        $this->authorize('delete', $comment);

        $this->commentService->deleteComment($comment);

        return to_route('articles.show', $article)
            ->with('success', 'Your comment successfully deleted!');
    }
}
