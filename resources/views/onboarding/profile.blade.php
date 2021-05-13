@extends('layouts.app')

@section('pageTitle', 'Onboarding ·')
@section('title', 'Onboarding ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container col-lg-5">
    <div class="text-center my-5">
        <img class="mb-3" src="https://ik.imagekit.io/taskordimg/bust_76KPFmEAu.png" height="70" alt="Taskord Logo">
        <div class="h1">Setup your profile!</div>
        <div class="mt-3 h4 lh-sm text-secondary fw-normal" style="letter-spacing:1px">
            Thanks for signing up to Taskord, you are going to love the community and awesome makers here.
        </div>
        <a class="btn btn-primary px-5 mt-4 fw-bold" href="{{ route('onboarding.profile') }}">
            Let's do it
        </a>
    </div>
</div>
@endsection
