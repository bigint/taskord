@extends('layouts.app')

@section('pageTitle', 'Tasks ·')

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @auth
                    @if (!auth()->user()->spammy)
                        <livewire:tasks.create-task />
                    @endif
                @endauth
                <livewire:tasks.all-tasks />
            </div>
        </div>
    </div>
@endsection
