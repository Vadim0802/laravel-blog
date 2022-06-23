<?php

namespace App\Services;

use App\Filters\SearchFilter;
use App\Filters\AuthorFilter;
use App\Filters\TagFilter;
use App\Models\Article;

class ArticleService
{
    public function getArticles(?string $tag = null, ?string $search = null, ?string $author = null, int $paginate = 10)
    {
        $filters = [
            'tag' => $tag,
            'search' => $search,
            'author' => $author
        ];

        $articles = $this->getFilteredArticles($filters)
            ->with(['author', 'tags'])
            ->latest()
            ->paginate($paginate);

        return $articles;
    }

    public function getFilteredArticles(array $filters)
    {
        $query = Article::query();

        $mappedFilters = [
            'tag' => TagFilter::class,
            'search' => SearchFilter::class,
            'author' => AuthorFilter::class
        ];

        foreach ($filters as $key => $value) {
            $filter = new ($mappedFilters[$key]);
            $filter($query, $value);
        }

        return $query;
    }

    public function getPopularArticles(int $count = 10)
    {
        $articles = Article::query()->orderBy('likes_count', 'desc')->limit($count)->get();

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
        $article->tags()->sync($tags);

        return $article;
    }

    public function updateArticle(string $title, string $content, string $slug, array $tags, Article $article)
    {
        $article->update([
            'title' => $title,
            'content' => $content,
            'slug' => $slug
        ]);

        $article->tags()->sync($tags);

        return $article;
    }

    public function deleteArticle(Article $article)
    {
        return $article->delete();
    }
}
