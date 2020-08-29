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
                'darkMode',
                'reputation',
                'isPrivate',
                'isFlagged',
                'isSuspended',
                'lastIP',
                'updated_at',
            )
            ->where('username', $username)->firstOrFail();
        $type = Route::current()->getName();

        $response = [
            'user' => $user,
            'type' => $type,
            'done_count' => Task::where([['user_id', $user->id], ['done', true]])
                ->count('id'),
            'pending_count' => Task::where([['user_id', $user->id], ['done', false]])
                ->count('id'),
            'product_count' => Product::where('user_id', $user->id)
                ->count('id'),
            'question_count' => Question::where('user_id', $user->id)
                ->count('id'),
            'answer_count' => Answer::where('user_id', $user->id)
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
            $tasks = Task::where('user_id', Auth::id())->get();
            $comment = Comment::where('user_id', Auth::id())->get();
            $products = Product::where('user_id', Auth::id())->get();
            $product_updates = ProductUpdate::where('user_id', Auth::id())->get();
            $questions = Question::where('user_id', Auth::id())->get();
            $answers = Answer::where('user_id', Auth::id())->get();
            $patron = Patron::where('user_id', Auth::id())->get();
            $data = collect([
                'account' => $account,
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

            return $response;
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }
    
    public function integrationSettings()
    {
        $user = Auth::user();

        return view('user.settings.integrations', [
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
