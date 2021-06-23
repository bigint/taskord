@extends('layouts.app')

@section('pageTitle', 'Settings / Sessions ·')

@section('content')
    <div class="container-md">
        <div class="row justify-content-center mt-4">
            @include('user.settings.sidebar')
            @livewire('user.settings.sessions', [
            'user' => $user
            ])
        </div>
    </div>
@endsection
