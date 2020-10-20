<?php

namespace App\Http\Controllers;

use App\Jobs\AuthGetIP;
use App\Models\User;
use App\Notifications\Logger;
use App\Notifications\Welcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Socialite;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function Callback(Request $request, $provider)
    {
        $userSocial = Socialite::driver($provider)->user();
        $user = User::where(['email' => $userSocial->getEmail()])->first();
        if ($user) {
            Auth::login($user);
            AuthGetIP::dispatch($user, $request->ip());

            $user->notify(
                new Logger(
                    'AUTH',
                    null,
                    $user,
                    "🔒 User logged in to Taskord\n\n`".$request->ip().'`'
                )
            );

            return redirect()->route('home');
        } else {
            if ($provider === 'twitter' or $provider === 'gitlab' or $provider === 'github') {
                $user = User::where(['username' => $userSocial->getNickname()])->first();
                if (! $user) {
                    $username = $userSocial->getNickname();
                } else {
                    $username = $userSocial->getNickname().'_'.Str::random(5);
                }
            } else {
                $username = $userSocial->getId();
            }

            if ($provider === 'gitlab' or $provider === 'github') {
                $avatar = $userSocial->avatar;
            } else {
                $avatar = str_replace('http://', 'https://', $userSocial->avatar_original);
            }

            $user = User::create([
                'username' => $username,
                'firstname' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'avatar' => $avatar,
                'provider_id' => $userSocial->getId(),
                'provider' => $provider,
                'email_verified_at' => date('Y-m-d H:i:s'),
            ]);
            AuthGetIP::dispatch($user, $request->ip());

            if ($provider === 'twitter') {
                $user->twitter = $userSocial->getNickname();
                $user->save();
            }

            Auth::login($user);

            $user->notify(
                new Logger(
                    'AUTH',
                    null,
                    $user,
                    '🎉 New user signed up to Taskord'
                )
            );
            $user->notify(new Welcome(true));

            return redirect()->route('home');
        }
    }
}
