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
    private TagService $tagService;
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService, TagService $tagService)
    {
        $this->articleService = $articleService;
        $this->tagService = $tagService;
    }

    public function index(Request $request)
    {
        $articles = $this->articleService->getArticles(
            $request->tag,
            $request->search
        );

        $tags = $this->tagService->getTags();
        $popularArticles = $this->articleService->getPopularArticles();

        return view('articles.index', compact('articles', 'popularArticles', 'tags'));
    }

    public function create()
    {
        $tags = $this->tagService->getTags();

        return view('articles.create', compact('tags'));
    }

    public function store(StoreArticleRequest $request)
    {
        $this->articleService->storeNewArticle(
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

    public function edit(Article $article)
    {
        $article->load('tags');
        $tags = $this->tagService->getTags();

        return view('articles.edit', compact('article', 'tags'));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $this->articleService->updateArticle(
            $request->title,
            $request->content,
            $request->slug,
            $request->tags,
            $article
        );

        return to_route('articles.show', $article)
            ->with('success', 'The article has been successfully updated!');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $this->articleService->deleteArticle($article);

        return to_route('articles.index')
            ->with('success', 'Article deleted successfully!');
    }
}
