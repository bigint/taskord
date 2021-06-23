@extends('layouts.app')

@section('pageTitle', 'Reset Password ·')

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form class="form-signin" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="text-center mb-4">
                        <img class="mb-4" src="https://ik.imagekit.io/taskordimg/logo_FLhAmih_U.svg" alt="Taskord Logo"
                            height="60" loading=lazy>
                        <h1 class="h3 mb-3 fw-bold">
                            Reset Password
                        </h1>
                    </div>
                    <div class="form-label-group">
                        <input type="text" id="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                            autocomplete="email" required autofocus>
                        <label for="email">Email</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button class="btn btn-lg btn-primary rounded-pill w-100" type="submit">
                        <span class="small">
                            <x-heroicon-o-mail class="heroicon heroicon-20px" />
                            Send Password Reset Link
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
