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
                    <img
                        class="mb-4"
                        src="/images/logo.svg"
                        alt=""
                        height="60"
                    >
                    <h1 class="h3 mb-2 fw-bold">
                        Sign in to your account
                    </h1>
                    <p>
                        Or <a class="fw-bold" href="/register">signup now!</a>
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
                        <a class="float-end fw-bold" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>
                <div class="btn-group w-100" role="group">
                    <button class="btn btn-lg btn-primary" name="submit" value="login" type="submit">
                        <span class="small">
                            <x-heroicon-o-lock-closed class="heroicon-2x" />
                            Login
                        </span>
                    </button>
                    <button class="btn btn-lg btn-dark" name="submit" value="magic-link" type="submit">
                        <span class="small">
                            <x-heroicon-o-mail class="heroicon-2x" />
                            Magic link
                        </span>
                    </button>
                </div>
                <div class="mt-3 row">
                    <div class="col-6">
                        <a href="/login/google" class="btn btn-social btn-google w-100">
                            <span class="small">
                                <img class="brand-icon" src="{{ asset('images/brand/google.svg') }}" />
                                Google
                            </span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="/login/twitter" class="btn btn-social btn-twitter w-100">
                            <span class="small">
                                <img class="brand-icon" src="{{ asset('images/brand/twitter.svg') }}" />
                                Twitter
                            </span>
                        </a>
                    </div>
                    <div class="col-6 mt-2">
                        <a href="/login/github" class="btn btn-social btn-github w-100">
                            <span class="small">
                                <img class="brand-icon" src="{{ asset('images/brand/github.svg') }}" />
                                GitHub
                            </span>
                        </a>
                    </div>
                    <div class="col-6 mt-2">
                        <a href="/login/gitlab" class="btn btn-social btn-gitlab w-100">
                            <span class="small">
                                <img class="brand-icon" src="{{ asset('images/brand/gitlab.svg') }}" />
                                GitLab
                            </span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
