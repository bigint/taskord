@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form class="form-signin" method="POST" action="{{ route('register') }}">
                @csrf
                @captcha
                <div class="text-center mb-4">
                    <img
                        class="mb-4"
                        src="/images/logo.svg"
                        alt=""
                        height="60"
                    >
                    <h1 class="h3 mb-3 font-weight-bold">
                        Sign up to Taskord
                    </h1>
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

                <div class="form-label-group">
                    <input
                        type="password"
                        id="password-confirm"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Confirm Password"
                        required
                        autocomplete="new-password"
                    >
                    <label for="password-confirm">Confirm Password</label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    <i class="fa fa-user-plus mr-1"></i>
                    Sign up
                </button>
                <div class="mt-3 row">
                    <div class="col-6">
                        <a href="/login/google" class="btn btn-lg btn-outline-danger btn-block" type="submit">
                            <i class="fa fa-google mr-1"></i>
                            Google
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="/login/twitter" class="btn btn-lg btn-outline-primary btn-block" type="submit">
                            <i class="fa fa-twitter mr-1"></i>
                            Twitter
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
