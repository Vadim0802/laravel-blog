<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ArticleTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = Article::all();
        $tags = Tag::all();

        foreach ($articles as $article) {
            foreach ($tags as $tag) {
                $article->tags()->attach($tag);
            }
        }
    }
}
