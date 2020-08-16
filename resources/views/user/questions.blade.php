@extends('layouts.app')

@php
if ($user->lastname) {
    $name = $user->firstname.' '.$user->lastname;
} else {
    $name = $user->firstname;
}
@endphp

@section('pageTitle', $user->username.' ('.$name.') / Questions ·')
@section('pageTitle', $user->username.' ('.$name.') / Questions ·')
@section('title', $user->username.' ('.$name.') ·')
@section('description', $user->bio)
@section('image', $user->avatar)
@section('url', url()->current())

@section('content')
<div class="container">
    @include('user.profile')
    <div class="row justify-content-center mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @livewire('user.questions', [
                        'user' => $user
                    ])
                </div>
                @include('user.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
