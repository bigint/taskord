@extends('layouts.app')

@section('pageTitle', 'Login ·')
@section('title', 'Login ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <form class="form-signin" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="text-center mb-3">
                        <img class="mb-4" src="https://ik.imagekit.io/taskordimg/logo_FLhAmih_U.svg" alt="Taskord Logo"
                            height="60" loading=lazy>
                        <h1 class="h3 mb-2 fw-bold">
                            Sign in to your account
                        </h1>
                        <p>
                            Or <a class="fw-bold" href="/register">signup now!</a>
                        </p>
                    </div>
                    <div class="form-label-group">
                        <input type="text" id="username" name="username" value="{{ old('username') }}"
                            class="form-control {{ session('error') ? 'is-invalid' : '' }}"
                            placeholder="Username or Email" autocomplete="username" required autofocus>
                        <label for="username">Username or Email</label>
                    </div>
                    <div class="form-label-group">
                        <input type="password" id="password" name="password"
                            class="form-control {{ session('error') ? 'is-invalid' : '' }}" placeholder="Password"
                            autocomplete="current-password">
                        <label for="password">Password</label>
                        @if (session()->has('error'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ session('error') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="float-end fw-bold" href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        @endif
                    </div>
                    <div class="btn-group w-100" role="group">
                        <button class="btn btn-lg btn-primary rounded-end rounded-pill" name="submit" value="login"
                            type="submit">
                            <span class="small">
                                <x-heroicon-o-lock-closed class="heroicon heroicon-20px" />
                                Login
                            </span>
                        </button>
                        <button class="btn btn-lg btn-dark rounded-start rounded-pill" name="submit" value="magic-link"
                            type="submit">
                            <span class="small">
                                <x-heroicon-o-mail class="heroicon heroicon-20px" />
                                Magic link
                            </span>
                        </button>
                    </div>
                    @if (feature('social_auth'))
                        <div class="mt-3 row">
                            <div class="col-6">
                                <a href="/login/google" class="btn btn-social btn-google rounded-pill w-100">
                                    <span class="small">
                                        <img class="brand-icon"
                                            src="https://ik.imagekit.io/taskordimg/icons/google_LPvasOP5AT.svg"
                                            loading=lazy />
                                        Google
                                    </span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="/login/twitter" class="btn btn-social btn-twitter rounded-pill w-100">
                                    <span class="small">
                                        <img class="brand-icon"
                                            src="https://ik.imagekit.io/taskordimg/icons/twitter_4cXueyhRfH.svg"
                                            loading=lazy />
                                        Twitter
                                    </span>
                                </a>
                            </div>
                            <div class="col-6 mt-2">
                                <a href="/login/github" class="btn btn-social btn-github rounded-pill w-100">
                                    <span class="small">
                                        <img class="brand-icon github-logo"
                                            src="https://ik.imagekit.io/taskordimg/icons/github_9E8bhMFJtH.svg"
                                            loading=lazy />
                                        GitHub
                                    </span>
                                </a>
                            </div>
                            <div class="col-6 mt-2">
                                <a href="/login/discord" class="btn btn-social btn-discord rounded-pill w-100">
                                    <span class="small">
                                        <img class="brand-icon"
                                            src="https://ik.imagekit.io/taskordimg/icons/discord_MCCBaztWr.webp"
                                            loading=lazy />
                                        Discord
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
