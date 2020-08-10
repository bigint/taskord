<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Product;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function done($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('user.done', [
            'user' => $user,
            'type' => 'user.done',
            'done_count' => Task::where([['user_id', $user->id], ['done', true]])->count(),
            'pending_count' => Task::where([['user_id', $user->id], ['done', false]])->count(),
            'product_count' => Product::where('user_id', $user->id)->count(),
            'question_count' => Question::where('user_id', $user->id)->count(),
            'answer_count' => Answer::where('user_id', $user->id)->count(),
        ]);
    }

    public function pending($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('user.pending', [
            'user' => $user,
            'type' => 'user.pending',
            'done_count' => Task::where([['user_id', $user->id], ['done', true]])->count(),
            'pending_count' => Task::where([['user_id', $user->id], ['done', false]])->count(),
            'product_count' => Product::where('user_id', $user->id)->count(),
            'question_count' => Question::where('user_id', $user->id)->count(),
            'answer_count' => Answer::where('user_id', $user->id)->count(),
        ]);
    }

    public function products($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('user.products', [
            'user' => $user,
            'done_count' => Task::where([['user_id', $user->id], ['done', true]])->count(),
            'pending_count' => Task::where([['user_id', $user->id], ['done', false]])->count(),
            'product_count' => Product::where('user_id', $user->id)->count(),
            'question_count' => Question::where('user_id', $user->id)->count(),
            'answer_count' => Answer::where('user_id', $user->id)->count(),
        ]);
    }

    public function questions($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('user.questions', [
            'user' => $user,
            'done_count' => Task::where([['user_id', $user->id], ['done', true]])->count(),
            'pending_count' => Task::where([['user_id', $user->id], ['done', false]])->count(),
            'product_count' => Product::where('user_id', $user->id)->count(),
            'question_count' => Question::where('user_id', $user->id)->count(),
            'answer_count' => Answer::where('user_id', $user->id)->count(),
        ]);
    }

    public function answers($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('user.answers', [
            'user' => $user,
            'done_count' => Task::where([['user_id', $user->id], ['done', true]])->count(),
            'pending_count' => Task::where([['user_id', $user->id], ['done', false]])->count(),
            'product_count' => Product::where('user_id', $user->id)->count(),
            'question_count' => Question::where('user_id', $user->id)->count(),
            'answer_count' => Answer::where('user_id', $user->id)->count(),
        ]);
    }

    public function following($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('user.following', [
            'user' => $user,
            'done_count' => Task::where([['user_id', $user->id], ['done', true]])->count(),
            'pending_count' => Task::where([['user_id', $user->id], ['done', false]])->count(),
            'product_count' => Product::where('user_id', $user->id)->count(),
            'question_count' => Question::where('user_id', $user->id)->count(),
            'answer_count' => Answer::where('user_id', $user->id)->count(),
        ]);
    }

    public function followers($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('user.followers', [
            'user' => $user,
            'done_count' => Task::where([['user_id', $user->id], ['done', true]])->count(),
            'pending_count' => Task::where([['user_id', $user->id], ['done', false]])->count(),
            'product_count' => Product::where('user_id', $user->id)->count(),
            'question_count' => Question::where('user_id', $user->id)->count(),
            'answer_count' => Answer::where('user_id', $user->id)->count(),
        ]);
    }

    public function profileSettings()
    {
        $user = Auth::user();

        return view('user.settings.profile', [
            'user' => $user,
        ]);
    }

    public function accountSettings()
    {
        $user = Auth::user();

        return view('user.settings.account', [
            'user' => $user,
        ]);
    }

    public function passwordSettings()
    {
        $user = Auth::user();

        return view('user.settings.password', [
            'user' => $user,
        ]);
    }

    public function notificationsSettings()
    {
        $user = Auth::user();

        return view('user.settings.notifications', [
            'user' => $user,
        ]);
    }

    public function deleteSettings()
    {
        $user = Auth::user();

        return view('user.settings.delete', [
            'user' => $user,
        ]);
    }

    public function darkMode()
    {
        $user = Auth::user();
        if ($user->darkMode) {
            $user->darkMode = false;
            $user->save();

            return 'disabled';
        } else {
            $user->darkMode = true;
            $user->save();

            return 'enabled';
        }
    }
}
