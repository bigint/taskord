@extends('layouts.app')

@section('pageTitle', 'Reset Password ·')

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form class="form-signin" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="text-center mb-4">
                    <img
                        loading=lazy
                        class="mb-4"
                        src="/images/logo.svg"
                        alt=""
                        height="60"
                    >
                    <h1 class="h3 mb-3 fw-bold">
                        Reset Password
                    </h1>
                </div>
                <div class="form-label-group">
                    <input
                        type="text"
                        id="email"
                        name="email"
                        value="{{ $email ?? old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email"
                        autocomplete="email"
                        required
                        autofocus
                    >
                    <label for="email">Email</label>
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
                        autocomplete="new-password"
                        required
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
                        autocomplete="new-password"
                        required
                    >
                    <label for="password-confirm">Confirm Password</label>
                </div>
                <button class="btn btn-lg btn-primary w-100" type="submit">
                    <span class="small">
                        <i class="fa fa-refresh me-1"></i>
                        Reset Password
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
