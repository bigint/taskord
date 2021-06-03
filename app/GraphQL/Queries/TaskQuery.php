<?php

namespace App\GraphQL\Queries;

class TaskQuery
{
    public function hasLiked($task)
    {
        if (auth()->check()) {
            return auth()->user()->hasLiked($task);
        }

        return null;
    }
}
