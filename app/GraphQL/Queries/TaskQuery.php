<?php

namespace App\GraphQL\Queries;

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
