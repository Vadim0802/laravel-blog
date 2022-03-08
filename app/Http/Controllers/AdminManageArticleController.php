<?php

namespace App\Http\Controllers;

use App\Models\Article;

class AdminManageArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()->with(['author'])->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.manage_articles', [
            'articles' => $articles
        ]);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return to_route('admin_manage_articles_index')->with('success', 'Article deleted successfully!');
    }
}
