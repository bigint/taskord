<?php

namespace App\Http\Middleware;

use Closure;

class IsPatron
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
        if ($request->user() && $request->user()->isPatron) {
            return $next($request);
        }

        return redirect('/');
    }
}
