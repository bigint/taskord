<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;

class AdminController extends Controller
{
    public function admin()
    {
        return view('admin.admin');
    }
    
    public function users()
    {
        return view('admin.users');
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
