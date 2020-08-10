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
    public function profile($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $type = \Route::current()->getName();
        
        $response = [
            'user' => $user,
            'type' => $type,
            'done_count' => Task::where([['user_id', $user->id], ['done', true]])->count(),
            'pending_count' => Task::where([['user_id', $user->id], ['done', false]])->count(),
            'product_count' => Product::where('user_id', $user->id)->count(),
            'question_count' => Question::where('user_id', $user->id)->count(),
            'answer_count' => Answer::where('user_id', $user->id)->count(),
        ];

        if (Auth::check() && Auth::id() === $user->id or Auth::check() && Auth::user()->staffShip) {
            return view($type, $response);
        } else if($user->isFlagged) {
            return view('errors.404');
        }
        
        return view($type, $response);
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
