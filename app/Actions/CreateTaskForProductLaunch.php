<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use App\Gamify\Points\TaskCreated;
use Illuminate\Support\Arr;
use App\Models\Product;
use App\Models\Task;

class CreateTaskForProductLaunch
{
    private array $tasks = [
        'I just launched a new product! Check out #%s',
        'Check  out #%s, I just lauched it today! 🚀',
        'Welcome into the world #%s!',
    ];

    public function execute(Product $product): void
    {
        $task = sprintf(Arr::random($this->tasks), $product->name);

        $task = Task::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'task' => $task,
            'done' => true,
            'done_at' => $product->launched_at,
            'images' => null,
            'due_at' => null,
            'type' => 'product',
            'source' => 'Taskord for Web',
        ]);

        givePoint(new TaskCreated($task));

        activity()
            ->withProperties(['type' => 'Task'])
            ->log('New task has been created U: @'.$task->user->username.' T: '.$task->id);
    }
}
