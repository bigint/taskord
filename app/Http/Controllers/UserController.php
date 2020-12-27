<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Patron;
use App\Models\Product;
use App\Models\ProductUpdate;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    public function profile($username)
    {
        $user = User::cacheFor(60 * 60)
            ->select(
                'id',
                'email',
                'username',
                'firstname',
                'lastname',
                'avatar',
                'bio',
                'location',
                'company',
                'status',
                'status_emoji',
                'sponsor',
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
                'darkMode',
                'reputation',
                'isPrivate',
                'isVerified',
                'isFlagged',
                'isSuspended',
                'lastIP',
                'timezone',
                'updated_at',
                'last_active',
                'email_verified_at',
            )
            ->where('username', $username)->firstOrFail();
        $type = Route::current()->getName();

        $response = [
            'user' => $user,
            'type' => $type,
            'level' => $user->badges->sortBy(function ($post) {
                return $post->pivot->created_at;
            }),
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

    public function patronSettings()
    {
        $user = Auth::user();

        return view('user.settings.patron', [
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

    public function exportAccount()
    {
        if (Auth::check()) {
            $account = User::find(Auth::id());
            $followings = $account->followings;
            $followers = $account->followers;
            $tasks = Task::where('user_id', Auth::id())->get();
            $comment = Comment::where('user_id', Auth::id())->get();
            $products = Product::where('user_id', Auth::id())->get();
            $product_updates = ProductUpdate::where('user_id', Auth::id())->get();
            $questions = Question::where('user_id', Auth::id())->get();
            $answers = Answer::where('user_id', Auth::id())->get();
            $patron = Patron::where('user_id', Auth::id())->get();
            $data = collect([
                'account' => $account,
                'followings' => $followings,
                'followers' => $followers,
                'tasks' => $tasks,
                'comments' => $comment,
                'products' => $products,
                'product_updates' => $product_updates,
                'questions' => $questions,
                'answers' => $answers,
                'patron' => $patron,
            ])->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            $file_name = Carbon::now()->format('d_m_Y_h_i_s').'_'.$account->username.'_data.json';
            $response = response($data, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="'.$file_name.'"',
            ]);
            activity()
                ->withProperties(['type' => 'User'])
                ->log('Exported the account data');

            return $response;
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
            ]);
        }
    }

    public function exportLogs()
    {
        if (Auth::check()) {
            $logs = Activity::causedBy(Auth::user())
                ->get();
            $data = collect([
                'logs' => $logs,
            ])->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            $file_name = Carbon::now()->format('d_m_Y_h_i_s').'_'.Auth::user()->username.'_logs.json';
            $response = response($data, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="'.$file_name.'"',
            ]);
            activity()
                ->withProperties(['type' => 'User'])
                ->log('Exported the account logs');

            return $response;
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
            ]);
        }
    }

    public function integrationsSettings()
    {
        $user = Auth::user();

        return view('user.settings.integrations', [
            'user' => $user,
        ]);
    }

    public function apiSettings()
    {
        $user = Auth::user();

        return view('user.settings.api', [
            'user' => $user,
        ]);
    }

    public function logsSettings()
    {
        $user = Auth::user();

        return view('user.settings.logs', [
            'user' => $user,
        ]);
    }

    public function dataSettings()
    {
        $user = Auth::user();

        return view('user.settings.data', [
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

    public function avatar($username)
    {
        $avatar = User::cacheFor(60 * 60)->where('username', $username)->first();

        return redirect($avatar->avatar);
    }

    public function mention(Request $request)
    {
        if ($request['query']) {
            $users = User::cacheFor(60 * 60)
                ->select('username', 'firstname', 'lastname', 'avatar', 'isVerified')
                ->where('username', 'LIKE', '%'.$request['query'].'%')
                ->orWhere('firstname', 'LIKE', '%'.$request['query'].'%')
                ->orWhere('lastname', 'LIKE', '%'.$request['query'].'%')
                ->take(10)
                ->get();
        } else {
            $users = '';
        }

        return $users;
    }

    public function popover($id)
    {
        $user = User::find($id);

        return view('user.popover', [
            'user' => $user,
        ]);
    }

    public function darkMode()
    {
        $user = Auth::user();
        if ($user->darkMode) {
            $user->darkMode = false;
            $user->save();
            activity()
                ->withProperties(['type' => 'User'])
                ->log('Disabled Dark mode');

            return response()->json([
                'status' => 'disabled',
            ]);
        } else {
            $user->darkMode = true;
            $user->save();
            activity()
                ->withProperties(['type' => 'User'])
                ->log('Enabled Dark mode');

            return response()->json([
                'status' => 'enabled',
            ]);
        }
    }

    public function suspended()
    {
        return view('auth.suspended');
    }
}
