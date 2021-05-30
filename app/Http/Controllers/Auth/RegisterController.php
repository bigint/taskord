<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\AuthGetIP;
use App\Models\User;
use App\Notifications\Welcome;
use App\Rules\ReservedSlug;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'alpha_dash', 'string', 'min:2', 'max:20', 'unique:users', new ReservedSlug()],
            'email' => ['required', 'string', 'email', 'indisposable', 'max:255', 'unique:users'],
            'password' => ['required', 'string', Password::min(8)->uncompromised()],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'avatar' => 'https://avatar.tobi.sh/'.Str::orderedUuid().'.svg?text='.strtoupper(substr($data['username'], 0, 2)),
            'password' => Hash::make($data['password']),
            'last_ip' => request()->ip(),
            'api_token' => Str::random(60),
        ]);
        AuthGetIP::dispatch($user, request()->ip());
        loggy(request(), 'Auth', $user, 'Created account with the email '.$user->email.' from '.request()->ip());
        $user->notify(new Welcome(true));

        return $user;
    }
}
