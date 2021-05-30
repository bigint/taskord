<?php

namespace App\Http\Controllers;

use App\Models\Task;

class TaskController extends Controller
{
    public function task($id)
    {
        $task = Task::where('id', $id)
            ->firstOrFail();
        $response = [
            'task' => $task,
        ];
        if (
            auth()->check() && auth()->user()->id === $task->user->id or
            auth()->check() && auth()->user()->staff_mode
        ) {
            return view('task/task', $response);
        }

        if ($task->user->spammy or $task->user->is_private) {
            return abort(404);
        }

        return view('task/task', $response);
    }

    public function comment($id, $comment_id)
    {
        $task = Task::where('id', $id)
            ->firstOrFail();
        $comment = $task->comments->where('id', $comment_id)->first();
        if (! $comment) {
            return abort(404);
        }

        $response = [
            'task' => $task,
            'comment' => $comment,
        ];

        if (
            auth()->check() && auth()->user()->id === $task->user->id or
            auth()->check() && auth()->user()->staff_mode
        ) {
            return view('comment/comment', $response);
        }

        if ($task->user->spammy or $task->user->is_private) {
            return abort(404);
        }

        return view('comment/comment', $response);
    }
}
