<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\AuthGetIP;
use App\Models\User;
use App\Notifications\Logger;
use App\Notifications\MagicLink;
use App\Providers\RouteServiceProvider;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function sendLoginLink($request)
    {
        $username = $request->input('username');
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $username)->first();
        } else {
            $user = User::where('username', $username)->first();
        }

        if (! $user) {
            $request->session()->flash('error', 'No user found with "'.$request->input('username').'"');

            return redirect()->back();
        } else {
            $generator = new LoginUrl($user);
            $generator->setRedirectUrl('/');
            $url = $generator->generate();
            $user->notify(new MagicLink($url));
            $request->session()->flash('global', 'Magic link has been sent to your email');
            AuthGetIP::dispatch($user, $request->ip());

            return redirect()->route('home');
        }
    }

    public function login(Request $request)
    {
        if ($request->input('submit') === 'magic-link') {
            return $this->sendLoginLink($request);
        }

        $input = $request->all();
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (auth()->attempt([$fieldType => $input['username'], 'password' => $input['password']])) {
            $request->session()->flash('global', 'Welcome back!');
            AuthGetIP::dispatch(auth()->user(), $request->ip());
            auth()->user()->notify(
                new Logger(
                    'AUTH',
                    null,
                    auth()->user(),
                    "🔒 User logged in to Taskord\n\n`".$request->ip().'`'
                )
            );
            activity()
                ->withProperties(['type' => 'Auth'])
                ->log('User logged in via Taskord auth from ' . $request->ip());

            return redirect()->route('home');
        } else {
            activity()
                ->withProperties(['type' => 'Auth'])
                ->log('User login failed');
            $request->session()->flash('error', 'Invalid login credentials');

            return redirect()->back();
        }
    }
}
