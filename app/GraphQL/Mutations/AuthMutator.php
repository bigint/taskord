<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AuthMutator
{
    public function __invoke($_, array $args)
    {
        if (auth()->check()) {
            if (auth()->user()->is_suspended) {
                return [
                    'message' => 'Your account is suspended!',
                ];
            }

            return [
                'message' => 'Already logged in',
            ];
        } else {
            $credentials = Arr::only($args, ['email', 'password']);

            if (Auth::once($credentials)) {
                if (auth()->user()->is_suspended) {
                    return [
                        'message' => 'Your account is suspended!',
                    ];
                }

                return [
                    'user' => auth()->user(),
                    'token' => auth()->user()->api_token,
                    'message' => 'Success',
                ];
            }

            return [
                'message' => 'Invalid Credentials',
            ];
        }

        return null;
    }
}
