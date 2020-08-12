<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function task($id)
    {
        $task = Task::where('id', $id)->firstOrFail();
        $response = [
            'task' => $task,
        ];
        if (Auth::check() && Auth::id() === $task->user->id or Auth::check() && Auth::user()->staffShip) {
            return view('task/task', $response);
        } else {
            return view('errors.404');
        }
        
        return view('task/task', $response);
    }

    public function tasks()
    {
        return view('tasks/tasks');
    }
}
