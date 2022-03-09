<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ArticleSeeder::class,
            ArticleCommentSeeder::class,
            ArticleLikeSeeder::class,
            TagSeeder::class,
            ArticleTagSeeder::class
        ]);
    }
}
