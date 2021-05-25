<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsBeta
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->is_beta) {
            return $next($request);
        }

        return redirect('/');
    }
}
