@extends('layouts.app')

@section('pageTitle', 'Settings / Integrations ·')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="container">
            <div class="row">
                @include('user.settings.sidebar')
                @livewire('user.settings.integrations', [
                    'user' => $user
                ])
            </div>
        </div>
    </div>
</div>
@endsection
