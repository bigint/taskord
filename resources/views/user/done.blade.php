@extends('layouts.app')

@section('content')
<div class="container">
    @include('user.profile')
    <div class="row justify-content-center mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if (Auth::check() && Auth::id() === $user->id && !$user->isFlagged)
                        @livewire('create-task')
                    @endif
                    @livewire('user.tasks', [
                        'type' => 'user.done',
                        'user' => $user,
                        'page' => 1,
                        'perPage' => 3
                    ])
                </div>
                @include('user.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
