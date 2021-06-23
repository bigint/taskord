@extends('layouts.app')

@php
if ($user->lastname and $user->lastname) {
    $name = '(' . $user->firstname . ' ' . $user->lastname . ')';
} elseif ($user->firstname) {
    $name = '(' . $user->firstname . ')';
} else {
    $name = '';
}
@endphp

@section('pageTitle', $user->username . ' ' . $name . ' / Products ·')
@section('title', $user->username . ' ' . $name . ' / Products ·')
@section('title', $user->username . ' (' . $name . ') ·')
@section('description', $user->bio)
@section('image', $user->avatar)
@section('url', url()->current())

@section('content')
    <div class="container-md">
        @include('user.profile')
        <div class="row justify-content-center mt-4">
            <div class="col-lg-8 mb-4">
                @livewire('user.products', [
                'user' => $user,
                ])
            </div>
            @include('user.sidebar')
        </div>
    </div>
@endsection
