<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function create()
    {
        return auth()->check();
    }

    public function update(User $user, Article $article)
    {
        return $article->author()->is($user);
    }

    public function delete(User $user, Article $article)
    {
        return $article->author()->is($user);
    }
}
