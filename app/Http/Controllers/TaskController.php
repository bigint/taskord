<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function task($id)
    {
        $task = Task::cacheFor(60 * 60)
            ->where('id', $id)
            ->firstOrFail();
        $response = [
            'task' => $task,
        ];
        if (
            Auth::check() && Auth::id() === $task->user->id or
            Auth::check() && Auth::user()->staffShip
        ) {
            return view('task/task', $response);
        } elseif ($task->user->isFlagged or $task->user->isPrivate) {
            return view('errors.404');
        }

        return view('task/task', $response);
    }

    public function comment($id, $comment_id)
    {
        $task = Task::cacheFor(60 * 60)
            ->where('id', $id)
            ->firstOrFail();
        $comment = Comment::cacheFor(60 * 60)
            ->where('id', $comment_id)
            ->firstOrFail();
        $response = [
            'task' => $task,
            'comment' => $comment,
        ];
        if (
            Auth::check() && Auth::id() === $task->user->id or
            Auth::check() && Auth::user()->staffShip
        ) {
            return view('comment/comment', $response);
        } elseif ($task->user->isFlagged or $task->user->isPrivate) {
            return view('errors.404');
        }

        return view('comment/comment', $response);
    }

    public function tasks()
    {
        return view('tasks/tasks');
    }
}
