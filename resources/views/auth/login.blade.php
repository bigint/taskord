@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form class="form-signin" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="text-center mb-4">
                    <img
                        class="mb-4"
                        src="/images/logo.svg"
                        alt=""
                        height="60"
                    >
                    <h1 class="h3 mb-3 font-weight-bold">
                        Sign in to your account
                    </h1>
                    <p>
                        Or <a class="font-weight-bold" href="/">signup now!</a>
                    </p>
                </div>
                <div class="form-label-group">
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        class="form-control {{ session('error') ? 'is-invalid' : '' }}"
                        placeholder="Username or Email"
                        autocomplete="username"
                        required
                        autofocus
                    >
                    <label for="username">Username or Email</label>
                </div>
                <div class="form-label-group">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control {{ session('error') ? 'is-invalid' : '' }}"
                        placeholder="Password"
                        autocomplete="current-password"
                    >
                    <label for="password">Password</label>
                    @if (session()->has('error'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ session('error') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="checkbox mb-3">
                    <label>
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember" {{ old('remember') ? 'checked' : '' }}
                        >
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a class="float-right font-weight-bold" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>
                <div class="btn-group btn-block" role="group">
                    <button class="btn btn-lg btn-primary" name="submit" value="login" type="submit">
                        <span class="small">
                            <i class="fa fa-lock mr-1"></i>
                            Login
                        </span>
                    </button>
                    <button class="btn btn-lg btn-dark" name="submit" value="magic-link" type="submit">
                        <span class="small">
                            <i class="fa fa-magic mr-1"></i>
                            Magic link
                        </span>
                    </button>
                </div>
                <div class="mt-3 row">
                    <div class="col-6">
                        <a href="/login/google" class="btn btn-lg btn-outline-danger btn-block" type="submit">
                            <span class="small">
                                <i class="fa fa-google mr-1"></i>
                                Google
                            </span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="/login/twitter" class="btn btn-lg btn-outline-primary btn-block" type="submit">
                            <span class="small">
                                <i class="fa fa-twitter mr-1"></i>
                                Twitter
                            </span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="g_id_onload"
     data-client_id="{{ env('GOOGLE_CLIENT_ID') }}"
     data-login_uri="https://stg.taskord.com">
</div>
@endsection
