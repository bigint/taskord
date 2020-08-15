@extends('layouts.app')

@php
if ($user->lastname) {
    $name = $user->firstname.' '.$user->lastname;
} else {
    $name = $user->firstname;
}
@endphp

@section('pageTitle', $user->username.' ('.$name.') / Answers · ')

@section('content')
<div class="container">
    @include('user.profile')
    <div class="row justify-content-center mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @livewire('user.answers', [
                        'user' => $user
                    ])
                </div>
                @include('user.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
