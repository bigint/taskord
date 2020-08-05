<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Socialite;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function Callback($provider)
    {
        $userSocial = Socialite::driver($provider)->user();
        $users = User::where(['email' => $userSocial->getEmail()])->first();
        if ($users) {
            Auth::login($users);

            return redirect()->route('home');
        } else {
            $user = User::create([
                'username' => md5(microtime()),
                'firstname' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'avatar' => $userSocial->getAvatar(),
                'provider_id' => $userSocial->getId(),
                'provider' => $provider,
            ]);

            if ($provider === 'twitter') {
                $user->twitter = $userSocial->getNickname();
                $user->save();
            }

            Auth::login($user);

            return redirect()->route('home');
        }
    }
}
