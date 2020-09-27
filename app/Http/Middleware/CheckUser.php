<?php

namespace App\Http\Middleware;

use App\Jobs\AuthGetIP;
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
            AuthGetIP::dispatch(Auth::user(), request()->ip());
            if (Auth::user()->isSuspended) {
                Auth::logout();

                return redirect()->route('suspended');
            }
        }

        return $next($request);
    }
}
