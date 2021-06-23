@extends('layouts.app')

@section('pageTitle', 'Signup ·')
@section('title', 'Signup ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form class="form-signin" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="text-center mb-3">
                        <img class="mb-4" src="https://ik.imagekit.io/taskordimg/logo_FLhAmih_U.svg" alt="Taskord Logo"
                            height="60" loading=lazy>
                        <h1 class="h3 mb-2 fw-bold">
                            Sign up to Taskord
                        </h1>
                        <p>
                            Or <a class="fw-bold" href="/login">login now!</a>
                        </p>
                    </div>
                    <div class="form-label-group">
                        <input type="text" id="username" name="username" value="{{ old('username') }}"
                            class="form-control @error('username') is-invalid @enderror" placeholder="Username"
                            autocomplete="username" required autofocus>
                        <label for="username">Username</label>
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-label-group">
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="E-Mail Address" required
                            autocomplete="email">
                        <label for="email">E-Mail Address</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-label-group">
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password" required
                            autocomplete="new-password">
                        <label for="password">Password</label>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button class="btn btn-lg btn-primary rounded-pill w-100" type="submit">
                        <span class="small">
                            <x-heroicon-o-user-add class="heroicon heroicon-20px" />
                            Sign up
                        </span>
                    </button>
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
