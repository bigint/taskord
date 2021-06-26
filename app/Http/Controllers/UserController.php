<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    public function profile($username): View
    {
        $user = User::withCount(['questions', 'answers', 'milestones'])
            ->whereUsername($username)->firstOrFail();
        $type = Route::current()->getName();

        $response = [
            'user' => $user,
            'type' => $type,
            'level' => $user->badges->sortBy(function ($post) {
                return $post->pivot->created_at;
            }),
            'done_count' => $user->tasks()->whereDone(true)->count('id'),
            'pending_count' => $user->tasks()->whereDone(false)->count('id'),
            'products_count' => $user->ownedProducts()->count('id'),
            'questions_count' => $user->questions_count,
            'answers_count' => $user->answers_count,
            'milestones_count' => $user->milestones_count,
        ];

        if (auth()->check() && auth()->user()->id === $user->id or auth()->check() && auth()->user()->staff_mode) {
            return view($type, $response);
        }

        if ($user->spammy) {
            return abort(404);
        }

        return view($type, $response);
    }

    public function profileSettings(): View
    {
        return view('user.settings.profile', [
            'user' => auth()->user(),
        ]);
    }

    public function appearanceSettings(): View
    {
        return view('user.settings.appearance', [
            'user' => auth()->user(),
        ]);
    }

    public function accountSettings(): View
    {
        return view('user.settings.account', [
            'user' => auth()->user(),
        ]);
    }

    public function productsSettings(): View
    {
        return view('user.settings.products', [
            'user' => auth()->user(),
        ]);
    }

    public function patronSettings(): View
    {
        return view('user.settings.patron', [
            'user' => auth()->user(),
        ]);
    }

    public function passwordSettings(): View
    {
        return view('user.settings.password', [
            'user' => auth()->user(),
        ]);
    }

    public function notifySettings(): View
    {
        return view('user.settings.notifications', [
            'user' => auth()->user(),
        ]);
    }

    public function exportAccount()
    {
        if (auth()->check()) {
            $account = User::find(auth()->user()->id);
            $data = collect([
                'account' => $account,
                'followings' => $account->followings()->get(),
                'followers' => $account->followers()->get(),
                'tasks' => $account->tasks()->get(),
                'comments' => $account->comments()->get(),
                'products' => $account->ownedProducts()->get(),
                'product_updates' => $account->productUpdates()->get(),
                'questions' => $account->questions()->get(),
                'answers' => $account->answers()->get(),
                'milestones' => $account->milestones()->get(),
                'patron' => $account->patron()->get(),
            ])->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            $fileName = carbon()->format('d_m_Y_h_i_s').'_'.$account->username.'_data.json';
            $response = response($data, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
            ]);
            loggy(request(), 'User', auth()->user(), 'Exported the account data');

            return $response;
        }

        return toast($this, 'error', config('taskord.toast.deny'));
    }

    public function exportLogs()
    {
        if (auth()->check()) {
            $logs = Activity::causedBy(auth()->user())
                ->get();
            $data = collect([
                'logs' => $logs,
            ])->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            $fileName = carbon()->format('d_m_Y_h_i_s').'_'.auth()->user()->username.'_logs.json';
            $response = response($data, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
            ]);
            loggy(request(), 'User', auth()->user(), 'Exported the account logs');

            return $response;
        }

        return toast($this, 'error', config('taskord.toast.deny'));
    }

    public function integrationsSettings(): View
    {
        return view('user.settings.integrations', [
            'user' => auth()->user(),
        ]);
    }

    public function apiSettings(): View
    {
        return view('user.settings.api', [
            'user' => auth()->user(),
        ]);
    }

    public function sessionsSettings(): View
    {
        return view('user.settings.sessions', [
            'user' => auth()->user(),
        ]);
    }

    public function logsSettings(): View
    {
        return view('user.settings.logs', [
            'user' => auth()->user(),
        ]);
    }

    public function dataSettings(): View
    {
        return view('user.settings.data', [
            'user' => auth()->user(),
        ]);
    }

    public function deleteSettings(): View
    {
        return view('user.settings.delete', [
            'user' => auth()->user(),
        ]);
    }

    public function mention(Request $request)
    {
        if ($request['query']) {
            $users = User::select('username', 'firstname', 'lastname', 'avatar', 'is_verified')
                ->search($request['query'])
                ->take(10)
                ->get();
        } else {
            $users = '';
        }

        return $users;
    }

    public function popover(User $user): View
    {
        return view('user.popover', [
            'user' => $user,
        ]);
    }

    public function json($username)
    {
        $user = User::withCount([
            'tasks',
            'comments',
            'questions',
            'answers',
            'milestones',
            'followers',
            'followings',
        ])
            ->whereUsername($username)->firstOrFail();

        return [
            'id' => $user->id,
            'username' => $user->username,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'avatar' => $user->avatar,
            'bio' => $user->bio,
            'location' => $user->location,
            'company' => $user->company,
            'website' => $user->website,
            'twitter' => $user->twitter,
            'twitch' => $user->twitch,
            'github' => $user->github,
            'telegram' => $user->telegram,
            'youtube' => $user->youtube,
            'sponsor' => $user->sponsor,
            'is_staff' => $user->is_staff ? true : false,
            'is_contributor' => $user->is_contributor ? true : false,
            'is_beta' => $user->is_beta ? true : false,
            'is_patron' => $user->is_patron ? true : false,
            'is_private' => $user->is_private ? true : false,
            'is_verified' => $user->is_verified ? true : false,
            'has_goal' => $user->has_goal ? true : false,
            'daily_goal' => $user->daily_goal,
            'daily_goal_reached' => $user->daily_goal_reached ? true : false,
            'vacation_mode' => $user->vacation_mode ? true : false,
            'streaks' => $user->streaks,
            'tasks' => $user->tasks_count,
            'comments' => $user->comments_count,
            'questions' => $user->questions_count,
            'answers' => $user->answers_count,
            'milestones' => $user->milestones_count,
            'followers' => $user->followers_count,
            'following' => $user->followings_count,
            'status' => [
                'status_emoji' => $user->status_emoji,
                'status' => $user->status,
            ],
        ];
    }

    public function darkMode()
    {
        if (Cookie::get('color_mode') === 'light') {
            Cookie::queue('color_mode', 'dark', config('session.lifetime'));
            loggy(request(), 'User', auth()->user(), 'Toggled appearance');

            return response()->json([
                'status' => 'disabled',
            ]);
        }

        Cookie::queue('color_mode', 'light', config('session.lifetime'));
        loggy(request(), 'User', auth()->user(), 'Toggled appearance');

        return response()->json([
            'status' => 'enabled',
        ]);
    }
}
