<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::latest('last_active')->paginate(50);
        $count = User::all()->count('id');

        return view('admin.users', [
            'users' => $users,
            'count' => number_format($count),
        ]);
    }

    public function tasks()
    {
        $tasks = Task::latest()->paginate(50);
        $count = Task::all()->count('id');

        return view('admin.tasks', [
            'tasks' => $tasks,
            'count' => number_format($count),
        ]);
    }

    public function activities()
    {
        $activities = Activity::latest()->paginate('50');
        $count = Activity::all()->count('id');

        return view('admin.activities', [
            'activities' => $activities,
            'count' => number_format($count),
        ]);
    }

    public static function toggle()
    {
        $user = Auth::user();
        if ($user->staffShip) {
            $user->staffShip = false;
            $user->save();
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Disabled StaffShip');

            return 'disabled';
        } else {
            $user->staffShip = true;
            $user->save();
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Enabled StaffShip');

            return 'enabled';
        }
    }
}
