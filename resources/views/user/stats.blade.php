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

@section('pageTitle', $user->username . ' ' . $name . ' / Stats ·')
@section('title', $user->username . ' ' . $name . ' / Stats ·')
@section('title', $user->username . ' (' . $name . ') ·')
@section('description', $user->bio)
@section('image', $user->avatar)
@section('url', url()->current())

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <div class="container-md">
        @include('user.profile')
        <div class="row justify-content-center mt-4">
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        @livewire('user.stats.all-tasks', [
                        'user' => $user
                        ])
                        @livewire('user.stats.completed-tasks', [
                        'user' => $user
                        ])
                        @livewire('user.stats.comments', [
                        'user' => $user
                        ])
                        @livewire('user.stats.answers', [
                        'user' => $user
                        ])
                    </div>
                </div>
            </div>
            @include('user.sidebar')
        </div>
    </div>
@endsection
