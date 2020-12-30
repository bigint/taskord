<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Factory as Auth;
use Carbon\CarbonImmutable;

use Closure;

class CheckUser
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * The immutable carbon instance.
     *
     * @var \Carbon\CarbonImmutable
     */
    protected $carbon;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @param  \Carbon\CarbonImmutable             $carbon
     * @return void
     */
    public function __construct(Auth $auth, CarbonImmutable $carbon)
    {
        $this->carbon = $carbon;
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            $request->user()->last_active = $this->carbon->now();
            $request->user()->save();

            if ($request->user()->isSuspended) {
                $this->auth->logout();

                return redirect()->route('suspended');
            }
        }

        return $next($request);
    }
}
