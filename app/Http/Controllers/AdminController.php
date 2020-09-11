<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::latest('updated_at')->paginate(50);
        $count = User::all()->count('id');

        return view('admin.users', [
            'users' => $users,
            'count' => $count,
        ]);
    }

    public static function toggle()
    {
        $user = Auth::user();
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
