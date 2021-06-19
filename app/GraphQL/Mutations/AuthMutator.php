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
                    'status' => false,
                    'message' => 'Your account is suspended!',
                ];
            }

            return [
                'status' => false,
                'message' => 'Already logged in',
            ];
        }

        $credentials = Arr::only($args, ['email', 'password']);

        if (Auth::once($credentials)) {
            if (auth()->user()->is_suspended) {
                return [
                    'status' => false,
                    'message' => 'Your account is suspended!',
                ];
            }

            return [
                'status' => true,
                'message' => 'Login successful',
                'user' => auth()->user(),
                'token' => auth()->user()->api_token,
            ];
        }

        return [
            'status' => false,
            'message' => 'Invalid Credentials',
        ];
    }
}
