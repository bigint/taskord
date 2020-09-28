<?php

namespace App\GraphQL\Queries;

use App\Models\Task;

class TaskQuery
{
    public function find($root, array $args)
    {
        $task = Task::find($args['id']);

        if ($task->hidden) {
            return null;
        }

        if ($task->user->isPrivate) {
            return null;
        }

        if ($task->user->isFlagged) {
            return null;
        }

        return $task;
    }
}
