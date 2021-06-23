@extends('layouts.app')

@section('pageTitle', 'Suspended ·')

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="text-center mb-4">
                    <img class="mb-4" src="https://ik.imagekit.io/taskordimg/logo_FLhAmih_U.svg" alt="Taskord Logo"
                        height="60" loading=lazy>
                    <h1 class="h3 mb-3 fw-bold">
                        Account suspended
                    </h1>
                    <div class="card">
                        <div class="card-body h6 lh-base mb-1">
                            <div>
                                Access to your account has been suspended due to a violation of our
                                <a href="{{ route('terms') }}">Terms of Service</a>.
                            </div>
                            <div class="mt-3">
                                Please <a href="{{ route('contact') }}">contact support</a> for more information.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
