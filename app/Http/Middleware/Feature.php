<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Taskord\LaravelUnleash\Unleash;

class Feature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $feature)
    {
        if (app(Unleash::class)->isFeatureEnabled($feature)) {
            return $next($request);
        }

        return redirect('/');
    }
}
