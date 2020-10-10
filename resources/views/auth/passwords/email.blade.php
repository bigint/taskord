@extends('layouts.app')

@section('pageTitle', 'Reset Password ·')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form class="form-signin" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="text-center mb-4">
                    <img
                        class="mb-4"
                        src="/images/logo.svg"
                        alt=""
                        height="60"
                    >
                    <h1 class="h3 mb-3 font-weight-bold">
                        Reset Password
                    </h1>
                </div>
                <div class="form-label-group">
                    <input
                        type="text"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
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
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    <span class="small">
                        <i class="fa fa-envelope mr-1"></i>
                        Send Password Reset Link
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
