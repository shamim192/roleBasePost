<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function manage(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function review(User $user, Post $post)
    {
        return $user->hasRole('super-admin') && $post->status === 'pending_review';
    }
}
