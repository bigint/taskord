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

@section('pageTitle', $user->username . ' ' . $name . ' / Pending ·')
@section('title', $user->username . ' ' . $name . ' / Pending ·')
@section('title', $user->username . ' (' . $name . ') ·')
@section('description', $user->bio)
@section('image', $user->avatar)
@section('url', url()->current())

@section('content')
    <div class="container-md">
        @include('user.profile')
        <div class="row justify-content-center mt-4">
            <div class="col-lg-8 mb-4">
                @auth
                    @if (auth()->user()->id === $user->id && !$user->spammy)
                        <div class="card mb-3">
                            <div class="card-body">
                                <livewire:create-task />
                            </div>
                        </div>
                    @endif
                @endauth
                @if (!$user->is_private or auth()->check() and auth()->user()->id === $user->id or auth()->check() and auth()->user()->staff_mode)
                    @livewire('user.tasks', [
                    'type' => 'user.pending',
                    'user' => $user,
                    'page' => 1,
                    'perPage' => 3
                    ])
                @else
                    <div class="card-body text-center mt-3 mb-3">
                        <x-heroicon-o-lock-closed class="heroicon heroicon-60px text-primary mb-2" />
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
