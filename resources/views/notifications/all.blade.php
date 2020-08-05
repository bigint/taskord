@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a role="button" class="btn btn-primary mb-3" href="{{ route('notifications.unread') }}">
                Unread
                <span class="ml-1 badge bg-white text-black-50">
                    {{ Auth::user()->unreadNotifications->count() }}
                </span>
            </a>
            <a role="button" class="btn btn-primary mb-3 mr-2" href="{{ route('notifications.all') }}">
                All
            </a>
            @if (Auth::user()->notifications->count() !== 0)
            @livewire('notification.delete')
            @endif
            @livewire('notification.all', [
                'type' => 'all',
                'page' => 1,
                'perPage' => 10
            ])
        </div>
    </div>
</div>
@endsection
