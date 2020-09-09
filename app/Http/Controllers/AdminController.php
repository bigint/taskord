<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function admin()
    {
        return view('admin.admin');
    }

    public function users()
    {
        $users = User::paginate(50);
        return view('admin.users', [
            'users' => $users,
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
