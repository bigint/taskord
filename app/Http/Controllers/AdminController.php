<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public static function toggle()
    {
        if (auth()->user()->staffShip) {
            auth()->user()->staffShip = false;
            auth()->user()->save();
            loggy('Admin', auth()->user(), 'Disabled Staff Ship');

            return response()->json([
                'status' => 'disabled',
            ]);
        } else {
            auth()->user()->staffShip = true;
            auth()->user()->save();
            loggy('Admin', auth()->user(), 'Enabled Staff Ship');

            return response()->json([
                'status' => 'enabled',
            ]);
        }
    }
}
