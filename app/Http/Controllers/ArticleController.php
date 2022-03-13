<?php

namespace App\Http\Controllers;

use App\Services\TagService;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Requests\StoreArticleRequest;
use App\Services\ArticleService;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(Request $request, ArticleService $articleService, TagService $tagService)
    {
        $articles = $articleService->getArticles(
            $request->tag,
            $request->search
        );

        $tags = $tagService->getTags();
        $popularArticles = $articleService->getPopularArticles();

        return view('articles.index', compact('articles', 'popularArticles', 'tags'));
    }

    public function create(TagService $tagService)
    {
        $tags = $tagService->getTags();

        return view('articles.create', compact('tags'));
    }

    public function store(StoreArticleRequest $request, ArticleService $articleService)
    {
        $articleService->storeNewArticle(
            $request->title,
            $request->content,
            $request->slug,
            $request->tags
        );

        return to_route('articles.index')
            ->with('success', 'Article created successfully!');
    }

    public function show(Article $article)
    {
        $article->load(['comments', 'author', 'likes', 'tags']);

        return view('articles.show', compact('article'));
    }

    public function edit(Article $article, TagService $tagService)
    {
        $article->load('tags');
        $tags = $tagService->getTags();

        return view('articles.edit', compact('article', 'tags'));
    }

    public function update(UpdateArticleRequest $request, Article $article, ArticleService $articleService)
    {
        $articleService->updateArticle(
            $request->title,
            $request->content,
            $request->slug,
            $request->tags,
            $article
        );

        return to_route('articles.show', $article)
            ->with('success', 'The article has been successfully updated!');
    }

    public function destroy(Article $article, ArticleService $articleService)
    {
        $this->authorize('delete', $article);
        $articleService->deleteArticle($article);

        return to_route('articles.index')
            ->with('success', 'Article deleted successfully!');
    }
}
