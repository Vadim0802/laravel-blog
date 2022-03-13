<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleService;

class AdminManageArticleController extends Controller
{
    public function index(ArticleService $articleService)
    {
        $articles = $articleService->getArticles(null, null);

        return view('admin.manage_articles', compact('articles'));
    }

    public function destroy(Article $article, ArticleService $articleService)
    {
        $articleService->deleteArticle($article);

        return to_route('admin_manage_articles_index')->with('success', 'Article deleted successfully!');
    }
}
