<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Jobs\AuthGetIP;

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
            AuthGetIP::dispatch(Auth::user(), request()->ip());
            if (Auth::user()->isSuspended) {
                Auth::logout();

                return redirect()->route('suspended');
            }
        }

        return $next($request);
    }
}
