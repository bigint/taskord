<?php

namespace App\Http\Middleware;

use Closure;

class IsBeta
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
        if ($request->user() && $request->user()->isBeta) {
            return $next($request);
        }

        return redirect('/');
    }
}
