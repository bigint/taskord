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
            return 'Task was hidden by moderator';
        }

        return $task->task;
    }
}
