@extends('layouts.app')

@php
if ($user->lastname and $user->lastname) {
    $name = '('.$user->firstname.' '.$user->lastname.')';
} else if ($user->firstname) {
    $name = '('.$user->firstname.')';
} else {
    $name = '';
}
@endphp

@section('pageTitle', $user->username.' '.$name.' / Followers ·')
@section('title', $user->username.' '.$name.' / Followers ·')
@section('title', $user->username.' ('.$name.') ·')
@section('description', $user->bio)
@section('image', asset('storage/' . $user->avatar))
@section('url', url()->current())

@section('content')
<div class="container">
    @include('user.profile')
    <div class="row justify-content-center mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @livewire('user.followers', ['user' => $user])
                </div>
                @include('user.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
