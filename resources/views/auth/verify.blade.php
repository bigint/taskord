@extends('layouts.app')

@section('pageTitle', 'Verify ·')

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">Verify Your Email Address</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                A fresh verification link has been sent to your email address.
                            </div>
                        @endif

                        Before proceeding, please check your email for a verification link.
                        If you did not receive the email
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="align-baseline btn m-0 p-0 rm-shadow text-primary">click here to
                                request another</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
