@extends('layouts.app')

@php
if ($user->lastname) {
    $name = $user->firstname.' '.$user->lastname;
} else {
    $name = $user->firstname;
}
@endphp

@section('pageTitle', $user->username.' ('.$name.') · ')

@section('content')
<div class="container">
    @include('user.profile')
    <div class="row justify-content-center mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @auth
                    @if (Auth::id() === $user->id && !$user->isFlagged)
                        @livewire('create-task')
                    @endif
                    @endauth
                    @if (
                        !$user->isPrivate or
                        Auth::id() === $user->id or
                        Auth::check() && Auth::user()->staffShip
                    )
                    @livewire('user.tasks', [
                        'type' => 'user.done',
                        'user' => $user,
                        'page' => 1,
                        'perPage' => 3
                    ])
                    @else
                    @include('components.empty', [
                        'icon' => 'lock',
                        'text' => 'All tasks are private',
                    ])
                    @endif
                </div>
                @include('user.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
