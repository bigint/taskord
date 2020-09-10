<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Socialite;
use App\Jobs\AuthGetIP;
use Illuminate\Http\Request;

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

            return redirect()->route('home');
        } else {
            $user = User::create([
                'username' => md5(microtime()),
                'firstname' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'avatar' => $userSocial->getAvatar(),
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

            return redirect()->route('home');
        }
    }
}
