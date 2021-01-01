<?php

namespace App\Actions;

use App\Models\Task;
use App\Models\User;

class CreateNewTask
{
    private const DEFAULT_SOURCE = 'Taskord for Web';

    protected bool $silent;
    protected array $data;
    protected User $user;

    public function __construct(
        User $user,
        array $data,
        bool $silent = false
    ) {
        $this->user = $user;
        $this->data = $data;
        $this->silent = $silent;
    }

    public function __invoke(): Task
    {
        $task = $this->createTaskModel();

        ($this->silent)
            ?: $this->updateActivity($task);

        return $task;
    }

    public function updateActivity(Task $task)
    {
        $message = "Created a new task via {$task->source}";

        activity()
                ->withProperties(['type' => 'Task'])
                ->log(\sprintf('%s | Task ID: %d', $message, $task->id));
    }

    public function createTaskModel(): Task
    {
        return Task::create(
            \array_merge([
                'user_id' => $this->user->id,
                'source' => CreateNewTask::DEFAULT_SOURCE,
            ], $this->data)
        );
    }
}
