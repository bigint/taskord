<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Contracts\View\View;

class TaskController extends Controller
{
    public function task($id): View
    {
        $task = Task::where('id', $id)
            ->with(['user', 'product', 'milestone', 'comments.user', 'oembed'])
            ->firstOrFail();
        $response = [
            'task' => $task,
        ];
        if (
            auth()->check() && auth()->user()->id === $task->user->id or
            auth()->check() && auth()->user()->staff_mode
        ) {
            return view('task.task', $response);
        }

        if ($task->user->spammy or $task->user->is_private) {
            return abort(404);
        }

        return view('task.task', $response);
    }

    public function comment($id, $comment_id): View
    {
        $task = Task::where('id', $id)
            ->with(['user', 'comments.user'])
            ->firstOrFail();
        $comment = $task->comments()
            ->with(['user'])
            ->where('id', $comment_id)->first();
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
            return view('comment.comment', $response);
        }

        if ($task->user->spammy or $task->user->is_private) {
            return abort(404);
        }

        return view('comment.comment', $response);
    }
}
