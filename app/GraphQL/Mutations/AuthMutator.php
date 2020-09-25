<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthMutator
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function login($root, array $args)
    {
        $credentials = Arr::only($args, ['email', 'password']);

        if (Auth::once($credentials)) {
            $token = Str::random(60);
            $user = auth()->user();
            $user->api_token = $token;
            $user->save();

            return $token;
        }

        return null;
    }
}
