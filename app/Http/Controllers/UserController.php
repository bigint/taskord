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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    public function profile($username)
    {
        $user = User::cacheFor(60 * 60)
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

        if (Auth::check() && auth()->user()->id === $user->id or Auth::check() && auth()->user()->staffShip) {
            return view($type, $response);
        } elseif ($user->isFlagged) {
            return view('errors.404');
        }

        return view($type, $response);
    }

    public function profileSettings()
    {
        return view('user.settings.profile', [
            'user' => auth()->user(),
        ]);
    }

    public function accountSettings()
    {
        return view('user.settings.account', [
            'user' => auth()->user(),
        ]);
    }

    public function patronSettings()
    {
        return view('user.settings.patron', [
            'user' => auth()->user(),
        ]);
    }

    public function passwordSettings()
    {
        return view('user.settings.password', [
            'user' => auth()->user(),
        ]);
    }

    public function notificationsSettings()
    {
        return view('user.settings.notifications', [
            'user' => auth()->user(),
        ]);
    }

    public function exportAccount()
    {
        if (Auth::check()) {
            $account = User::find(auth()->user()->id);
            $followings = $account->followings;
            $followers = $account->followers;
            $tasks = Task::where('user_id', auth()->user()->id)->get();
            $comment = Comment::where('user_id', auth()->user()->id)->get();
            $products = Product::where('user_id', auth()->user()->id)->get();
            $product_updates = ProductUpdate::where('user_id', auth()->user()->id)->get();
            $questions = Question::where('user_id', auth()->user()->id)->get();
            $answers = Answer::where('user_id', auth()->user()->id)->get();
            $patron = Patron::where('user_id', auth()->user()->id)->get();
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

            $file_name = carbon()->format('d_m_Y_h_i_s').'_'.$account->username.'_data.json';
            $response = response($data, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="'.$file_name.'"',
            ]);
            loggy('User', auth()->user(), 'Exported the account data');

            return $response;
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function exportLogs()
    {
        if (Auth::check()) {
            $logs = Activity::causedBy(auth()->user())
                ->get();
            $data = collect([
                'logs' => $logs,
            ])->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            $file_name = carbon()->format('d_m_Y_h_i_s').'_'.auth()->user()->username.'_logs.json';
            $response = response($data, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="'.$file_name.'"',
            ]);
            loggy('User', auth()->user(), 'Exported the account logs');

            return $response;
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function integrationsSettings()
    {
        return view('user.settings.integrations', [
            'user' => auth()->user(),
        ]);
    }

    public function apiSettings()
    {
        return view('user.settings.api', [
            'user' => auth()->user(),
        ]);
    }

    public function logsSettings()
    {
        return view('user.settings.logs', [
            'user' => auth()->user(),
        ]);
    }

    public function dataSettings()
    {
        return view('user.settings.data', [
            'user' => auth()->user(),
        ]);
    }

    public function deleteSettings()
    {
        return view('user.settings.delete', [
            'user' => auth()->user(),
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
        if (auth()->user()->darkMode) {
            auth()->user()->darkMode = false;
            auth()->user()->save();
            loggy('User', auth()->user(), 'Disabled Dark mode');

            return response()->json([
                'status' => 'disabled',
            ]);
        } else {
            auth()->user()->darkMode = true;
            auth()->user()->save();
            loggy('User', auth()->user(), 'Enabled Dark mode');

            return response()->json([
                'status' => 'enabled',
            ]);
        }
    }
}
