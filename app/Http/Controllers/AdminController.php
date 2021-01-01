<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    public static function toggle()
    {
        if (user()->staffShip) {
            user()->staffShip = false;
            user()->save();
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Disabled Staff Ship');

            return response()->json([
                'status' => 'disabled',
            ]);
        } else {
            user()->staffShip = true;
            user()->save();
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Enabled Staff Ship');

            return response()->json([
                'status' => 'enabled',
            ]);
        }
    }
}
