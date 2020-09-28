<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Article $article): bool
    {
        if ($user->group_id == 1){
            return true;
        }else{
            return $user->id === $article->user_id;
        }

    }

    public function delete(User $user, Article $article): bool
    {
        if ($user->group_id == 1){
            return true;
        }else{
            return $user->id === $article->user_id;
        }
    }
}
