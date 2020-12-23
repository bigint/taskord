<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;

class FeedController extends Controller
{
    public function user($username, $page = 1)
    {
        $user = User::where('username', $username)
            ->firstOrFail();
        $tasks = Task::where('user_id', $user->id)
            ->latest()
            ->offset($page - 1)
            ->limit(50)
            ->get();

        $content = view('feed.user', [
            'user' => $user,
            'tasks' => $tasks,
        ]);

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
