@extends('layouts.app')

@section('pageTitle', 'Tasks ·')

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @auth
                @if (!Auth::user()->isFlagged)
                @livewire('tasks.create-task')
                @endif
            @endauth
            @livewire('tasks.today')
            @livewire('tasks.all-time')
        </div>
    </div>
</div>
@endsection
