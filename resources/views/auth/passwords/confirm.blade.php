@extends('layouts.app')

@section('pageTitle', 'Confirm ·')

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form class="form-signin" method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="text-center mb-4">
                    <img
                        class="mb-4"
                        src="/images/logo.svg"
                        alt=""
                        height="60"
                    >
                    <h1 class="h3 mb-3 fw-bold">
                        Confirm password to continue
                    </h1>
                </div>
                <div class="form-label-group">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        value="{{ old('password') }}"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password"
                        autocomplete="current-password"
                        required
                        autofocus
                    >
                    <label for="password">Password</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if (Route::has('password.request'))
                    <a class="fw-bold" href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif
                <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">
                    <span class="small">
                        <i class="fa fa-check me-1"></i>
                        Confirm Password
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
