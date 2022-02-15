<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleLike;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $articles = Article::all();

        foreach ($users as $user) {
            foreach ($articles as $article) {
                ArticleLike::create(['user_id' => $user->id, 'article_id' => $article->id]);
                $article->update(['likes_count' => $article->likes_count + 1]);
            }
        }
    }
}
