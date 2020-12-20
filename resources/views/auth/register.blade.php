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
                    <img
                        loading=lazy
                        class="mb-4"
                        src="/images/logo.svg"
                        alt=""
                        height="60"
                    >
                    <h1 class="h3 mb-2 fw-bold">
                        Sign up to Taskord
                    </h1>
                    <p>
                        Or <a class="fw-bold" href="/login">login now!</a>
                    </p>
                </div>
                <div class="form-label-group">
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        class="form-control @error('username') is-invalid @enderror"
                        placeholder="Username"
                        autocomplete="username"
                        required
                        autofocus
                    >
                    <label for="username">Username</label>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-label-group">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="E-Mail Address"
                        required
                        autocomplete="email"
                    >
                    <label for="email">E-Mail Address</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-label-group">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password"
                        required
                        autocomplete="new-password"
                    >
                    <label for="password">Password</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button class="btn btn-lg btn-primary w-100" type="submit">
                    <span class="small">
                        <x-heroicon-o-user-add class="heroicon-2x" />
                        Sign up
                    </span>
                </button>
                <div class="mt-3 row">
                    <div class="col-6">
                        <a href="/login/google" class="btn btn-social btn-google w-100" data-turbolinks="false">
                            <span class="small">
                                <i class="fab fa-google me-1"></i>
                                Google
                            </span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="/login/twitter" class="btn btn-social btn-twitter w-100" data-turbolinks="false">
                            <span class="small">
                                <i class="fab fa-twitter me-1"></i>
                                Twitter
                            </span>
                        </a>
                    </div>
                    <div class="col-6 mt-2">
                        <a href="/login/github" class="btn btn-social btn-github w-100" data-turbolinks="false">
                            <span class="small">
                                <i class="fab fa-github me-1"></i>
                                GitHub
                            </span>
                        </a>
                    </div>
                    <div class="col-6 mt-2">
                        <a href="/login/gitlab" class="btn btn-social btn-gitlab w-100" data-turbolinks="false">
                            <span class="small">
                                <i class="fab fa-gitlab me-1"></i>
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
