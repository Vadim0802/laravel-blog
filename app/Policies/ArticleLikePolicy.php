<?php

namespace App\Policies;

use App\Models\ArticleLike;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticleLikePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return auth()->check();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleLike  $like
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ArticleLike $like)
    {
        return $user->id === $like->user_id;
    }
}
