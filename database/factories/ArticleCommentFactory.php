<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleCommentFactory extends Factory
{
    protected $model = ArticleComment::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all();
        $articles = Article::all();

        return [
            'content' => $this->faker->text(255),
            'user_id' => $users->random()->id,
            'article_id' => $articles->random()->id
        ];
    }
}
