<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return;
    }

    public function view(User $user, Post $post)
    {
        return;
    }

    public function create(User $user)
    {
        return;
    }

    public function update(User $user, Post $post)
    {
        if (!$post->author) {
            return true;
        }

        return $post->author->is($user);
    }

    public function delete(User $user, Post $post)
    {
        if (!$post->author) {
            return true;
        }

        return $post->author->is($user);
    }

    public function restore(User $user, Post $post)
    {
        if (!$post->author) {
            return true;
        }

        return $post->author->is($user);
    }

    public function forceDelete(User $user, Post $post)
    {
        if (!$post->author) {
            return true;
        }

        return $post->author->is($user);
    }
}
