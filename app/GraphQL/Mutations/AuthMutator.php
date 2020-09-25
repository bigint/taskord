<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AuthMutator
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        if (Auth::check()) {
            if (Auth::user()->isSuspended) {
                return 'Your account is suspended!';
            }
            
            return "Already logged in";
        } else {
            $credentials = Arr::only($args, ['email', 'password']);

            if (Auth::once($credentials)) {
                if (Auth::user()->isSuspended) {
                    return 'Your account is suspended!';
                }
                return Auth::user()->api_token;
            } else {
                return 'Invalid Credentials';
            }
        }

        return null;
    }
}
