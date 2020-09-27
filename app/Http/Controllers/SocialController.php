<?php

namespace App\Http\Controllers;

use App\Jobs\AuthGetIP;
use App\Models\User;
use App\Notifications\TelegramLogger;
use App\Notifications\Welcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        //dd($userSocial);
        $user = User::where(['email' => $userSocial->getEmail()])->first();
        if ($user) {
            Auth::login($user);
            AuthGetIP::dispatch($user, $request->ip());

            $user->notify(
                new TelegramLogger(
                    "*🔒 User logged in to Taskord*\n\nIP: `".$request->ip()."`\n\nhttps://taskord.com/@".$user->username
                )
            );

            return redirect()->route('home');
        } else {
            $user = User::create([
                'username' => md5(microtime()),
                'firstname' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'avatar' => $userSocial->avatar_original,
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
                new TelegramLogger(
                    "*🎉 New user signed up to Taskord*\n\nhttps://taskord.com/@".$user->username
                )
            );
            $user->notify(new Welcome(true));

            return redirect()->route('home');
        }
    }
}
