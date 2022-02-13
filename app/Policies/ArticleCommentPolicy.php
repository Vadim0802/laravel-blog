<?php

namespace App\Policies;

use App\Models\ArticleComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticleCommentPolicy
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
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleComment  $articleComment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ArticleComment $articleComment)
    {
        return $user->id === $articleComment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleComment  $articleComment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ArticleComment $articleComment)
    {
        return $user->id === $articleComment->user_id;
    }
}
