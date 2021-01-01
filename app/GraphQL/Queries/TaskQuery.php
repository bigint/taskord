<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Auth;

class TaskQuery
{
    public function getTask($task, array $args)
    {
        if (
            $task->hidden or
            $task->user->isFlagged or
            $task->user->isPrivate
        ) {
            return null;
        }

        return $task->task;
    }

    public function hasPraised($task, array $args)
    {
        if (Auth::check()) {
            return user()->hasLiked($task);
        } else {
            return null;
        }
    }
}
