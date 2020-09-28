<?php

namespace App\GraphQL\Queries;

use App\Models\Task;

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
}
