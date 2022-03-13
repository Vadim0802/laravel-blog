<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{
    public function getArticles(string|null $tag, string|null $search, int $paginate = 10)
    {
        $filters = $this->getFilters($tag, $search);
        $articles = Article::query()
            ->with(['author', 'tags'])
            ->filter($filters)
            ->latest()
            ->paginate($paginate);

        return $articles;
    }

    public function getPopularArticles(int $limit = 10)
    {
        $articles = Article::query()->popular($limit)->get();

        return $articles;
    }

    public function storeNewArticle(string $title, string $content, string $slug, array $tags)
    {
        $article = new Article([
            'title' => $title,
            'content' => $content,
            'slug' => $slug
        ]);
        $article->author()->associate(auth()->user());
        $article->save();

        $this->attachTagsToArticle($article, $tags);

        return $article;
    }

    public function updateArticle(string $title, string $content, string $slug, array $tags, Article $article)
    {
        $article->update([
            'title' => $title,
            'content' => $content,
            'slug' => $slug
        ]);

        $this->attachTagsToArticle($article, $tags);

        return $article;
    }

    public function deleteArticle(Article $article)
    {
        return $article->delete();
    }

    private function getFilters(string|null $tag, string|null $search)
    {
        $filters = [];

        if ($tag) {
            $filters['tag'] = $tag;
        }
        if ($search) {
            $filters['search'] = $search;
        }

        return $filters;
    }

    private function attachTagsToArticle(Article $article, array $tags)
    {
        $article->tags()->detach();
        foreach ($tags as $tag) {
            $article->tags()->attach($tag);
        }
    }
}
