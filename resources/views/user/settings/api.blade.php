@extends('layouts.app')

@section('pageTitle', 'Settings / API ·')

@section('content')
    <div class="container-md">
        <div class="row justify-content-center mt-4">
            @include('user.settings.sidebar')
            @livewire('user.settings.api', [
            'user' => $user
            ])
        </div>
    </div>
@endsection
