@extends('layouts.app')

@section('pageTitle', 'Onboarding ·')
@section('title', 'Onboarding ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container col-lg-5">
    <div class="text-center mt-5 mb-4">
        <img class="mb-3" src="https://ik.imagekit.io/taskordimg/bust_76KPFmEAu.png" height="70" alt="Taskord Logo">
        <div class="h1">Setup your profile!</div>
        <div class="mt-3 h5 lh-sm text-secondary fw-normal">
            To complete your profile, please tell us a little bit more about yourself
        </div>
    </div>
    <div>
        <livewire:onboarding.profile :user="auth()->user()" />
    </div>
</div>
@endsection
