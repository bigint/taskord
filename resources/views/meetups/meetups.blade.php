@extends('layouts.app')

@section('pageTitle', 'Meetups ·')
@section('title', 'Meetups ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="card">
            @include('meetups.header')
            <div class="card-body">
                @if (count($meetups) === 0)
                <div class="card-body text-center mt-3 mb-3">
                    <x-heroicon-o-user-group class="heroicon-4x text-primary mb-2" />
                    <div class="h4">
                        No meetups found
                    </div>
                </div>
                @endif
                <div class="container-fluid">
                    <div class="row">
                        @foreach ($meetups as $meetup)
                            @livewire('meetup.single-meetup', ['meetup' => $meetup])
                        @endforeach
                        {{ $meetups->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
