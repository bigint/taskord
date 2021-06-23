@extends('layouts.app')

@section('pageTitle', 'Settings / Data ·')

@section('content')
    <div class="container-md">
        <div class="row justify-content-center mt-4">
            @include('user.settings.sidebar')
            @livewire('user.settings.data', [
            'user' => $user
            ])
        </div>
    </div>
@endsection
