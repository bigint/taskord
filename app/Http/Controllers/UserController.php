<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Product;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    public function profile($username)
    {
        $user = User::select(
                'id',
                'username',
                'firstname',
                'lastname',
                'avatar',
                'bio',
                'location',
                'company',
                'website',
                'twitter',
                'twitch',
                'github',
                'telegram',
                'youtube',
                'isStaff',
                'isDeveloper',
                'isBeta',
                'isPatron',
                'isFlagged',
                'isSuspended',
            )
            ->where('username', $username)->firstOrFail();
        $type = Route::current()->getName();

        $response = [
            'user' => $user,
            'type' => $type,
            'done_count' => Task::cacheFor(60 * 60)
                ->where([['user_id', $user->id], ['done', true]])
                ->count('id'),
            'pending_count' => Task::cacheFor(60 * 60)
                ->where([['user_id', $user->id], ['done', false]])
                ->count('id'),
            'product_count' => Product::cacheFor(60 * 60)
                ->where('user_id', $user->id)
                ->count('id'),
            'question_count' => Question::cacheFor(60 * 60)
                ->where('user_id', $user->id)
                ->count('id'),
            'answer_count' => Answer::cacheFor(60 * 60)
                ->where('user_id', $user->id)
                ->count('id'),
        ];

        if (Auth::check() && Auth::id() === $user->id or Auth::check() && Auth::user()->staffShip) {
            return view($type, $response);
        } elseif ($user->isFlagged) {
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
    
    public function suspended()
    {
        return view('auth.suspended');
    }
}
