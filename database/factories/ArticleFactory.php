<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all();

        return [
            'title' => $this->faker->text(50),
            'slug' => $this->faker->slug(20),
            'content' => $this->faker->text(1000),
            'user_id' => $users->random()->id
        ];
    }
}
