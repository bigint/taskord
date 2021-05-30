<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsStaffMode
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
        if ($request->user() && $request->user()->staff_mode) {
            return $next($request);
        }

        return abort(404);
    }
}
