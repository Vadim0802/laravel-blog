<?php

namespace Database\Seeders;

use App\Models\ArticleComment;
use Illuminate\Database\Seeder;

class ArticleCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArticleComment::factory()->count(100)->create();
    }
}
