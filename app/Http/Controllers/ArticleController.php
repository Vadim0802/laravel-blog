<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Actions\StoreArticleAction;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Tag;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $articles = Article::query()
            ->with(['author', 'tags'])
            ->filter(request(['search', 'tag']))
            ->latest()
            ->paginate(10);

        $popularArticles = Article::popular(15)->get();
        $tags = Tag::all();

        return view('articles.index', [
            'articles' => $articles,
            'popularArticles' => $popularArticles,
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tags = Tag::all();

        return view('articles.create', [
            'tags' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreArticleRequest $request, StoreArticleAction $action)
    {
        $action($request->validated());

        return to_route('articles.index')
            ->with('success', 'Article created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function show(Article $article)
    {
        return view('articles.show', [
            'article' => $article->load(['comments', 'author', 'likes'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function edit(Article $article)
    {
        return view('articles.edit', [
            'article' => $article
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->update($request->validated());

        return to_route('articles.show', $article)
            ->with('success', 'The article has been successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();

        return to_route('articles.index')
            ->with('success', 'Article deleted successfully!');
    }
}
