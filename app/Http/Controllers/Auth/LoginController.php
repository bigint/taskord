<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\AuthGetIP;
use App\Models\User;
use App\Notifications\Auth\Login;
use App\Notifications\Auth\MagicLink;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function sendLoginLink($request): RedirectResponse
    {
        $username = $request->input('username');
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $user = User::whereEmail($username)->first();
        } else {
            $user = User::whereUsername($username)->first();
        }

        if (! $user) {
            $request->session()->flash('error', "No user found with {$request->input('username')}");

            return redirect()->back();
        }

        if (! $user->spammy) {
            $generator = new LoginUrl($user);
            $generator->setRedirectUrl('/');
            $url = $generator->generate();
            $user->notify(new MagicLink($url));
            $request->session()->flash('global', 'Magic link has been sent to your email');
            AuthGetIP::dispatch($user, $request->ip());

            return redirect()->route('home');
        }

        $request->session()->flash('global', 'Your account is flagged or suspended 😢');

        return redirect()->route('home');
    }

    public function login(Request $request): RedirectResponse
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
            auth()->user()->notify(new Login($request->ip()));
            loggy(request(), 'Auth', auth()->user(), 'Logged in via Taskord auth with '.auth()->user()->email);

            return redirect()->route('home');
        }

        $request->session()->flash('error', 'Invalid login credentials');

        return redirect()->back();
    }
}
