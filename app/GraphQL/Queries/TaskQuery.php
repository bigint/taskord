<?php

namespace App\GraphQL\Queries;

class TaskQuery
{
    public function hasPraised($task)
    {
        if (auth()->check()) {
            return auth()->user()->hasLiked($task);
        }

        return null;
    }
}
