<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleService;

class AdminManageArticleController extends Controller
{
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $articles = $this->articleService->getArticles(null, null);

        return view('admin.manage_articles', compact('articles'));
    }

    public function destroy(Article $article)
    {
        $this->articleService->deleteArticle($article);

        return to_route('admin_manage_articles_index')->with('success', 'Article deleted successfully!');
    }
}
