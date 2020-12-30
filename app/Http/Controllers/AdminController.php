<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    public static function toggle()
    {
        $user = Auth::user();
        if ($user->staffShip) {
            $user->staffShip = false;
            $user->save();
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Disabled Staff Ship');

            return response()->json([
                'status' => 'disabled',
            ]);
        } else {
            $user->staffShip = true;
            $user->save();
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Enabled Staff Ship');

            return response()->json([
                'status' => 'enabled',
            ]);
        }
    }
}
