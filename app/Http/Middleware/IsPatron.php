<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsPatron
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->is_patron) {
            return $next($request);
        }

        return redirect('/');
    }
}
