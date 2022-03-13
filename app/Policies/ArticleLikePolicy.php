<?php

namespace App\Policies;

use App\Models\ArticleLike;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticleLikePolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return auth()->check();
    }

    public function delete(User $user, ArticleLike $like)
    {
        return $like->user()->is($user);
    }
}
