<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public static function toggle()
    {
        if (auth()->user()->staffShip) {
            auth()->user()->staffShip = false;
            auth()->user()->save();
            loggy(request()->ip(), 'Admin', auth()->user(), 'Disabled Staff Ship');

            return response()->json([
                'status' => 'disabled',
            ]);
        } else {
            auth()->user()->staffShip = true;
            auth()->user()->save();
            loggy(request()->ip(), 'Admin', auth()->user(), 'Enabled Staff Ship');

            return response()->json([
                'status' => 'enabled',
            ]);
        }
    }

    public static function cacheHits()
    {
        $cache = Cache::getStore()->getMemcached()->getAllKeys();

        return view('site.cache', [
            'cache' => $cache,
        ]);
    }
}
