<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Taskord\LaravelUnleash\Unleash;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::latest('last_active')->paginate(50);
        $count = User::all()->count('id');

        return view('admin.users', [
            'users' => $users,
            'count' => $count,
        ]);
    }

    public static function toggle()
    {
        $user = Auth::user();
        if (app(Unleash::class)->isFeatureEnabled('admin_bar')) {
            if ($user->staffShip) {
                $user->staffShip = false;
                $user->save();
    
                return 'disabled';
            } else {
                $user->staffShip = true;
                $user->save();
    
                return 'enabled';
            }
        }
    }
}
