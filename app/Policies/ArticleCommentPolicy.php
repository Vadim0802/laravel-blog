<?php

namespace App\Policies;

use App\Models\ArticleComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticleCommentPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return auth()->check();
    }

    public function update(User $user, ArticleComment $comment)
    {
        return $comment->user()->is($user);
    }

    public function delete(User $user, ArticleComment $comment)
    {
        return $comment->user()->is($user);
    }
}
