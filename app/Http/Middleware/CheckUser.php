<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            Auth::user()->last_active = Carbon::now();
            Auth::user()->save();
            if (Auth::user()->isSuspended) {
                Auth::logout();

                return redirect()->route('suspended');
            }
        }

        return $next($request);
    }
}
