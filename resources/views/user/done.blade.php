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

@section('pageTitle', $user->username.' '.$name.' ·')
@section('title', $user->username.' '.$name.' ·')
@section('description', $user->bio)
@section('image', $user->avatar)
@section('url', url()->current())

@section('content')
<div class="container-md">
    @include('user.profile')
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8">
            @auth
            @if (Auth::id() === $user->id && !$user->isFlagged)
                @livewire('create-task')
            @endif
            @endauth
            @if (
                !$user->isPrivate or
                Auth::id() === $user->id or
                Auth::check() && user()->staffShip
            )
            @livewire('user.tasks', [
                'type' => 'user.done',
                'user' => $user,
                'page' => 1,
                'perPage' => 3
            ])
            @else
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-lock-closed class="heroicon-4x text-primary mb-2" />
                <div class="h4">
                    All tasks are private
                </div>
            </div>
            @endif
        </div>
        @include('user.sidebar')
    </div>
</div>
@endsection
