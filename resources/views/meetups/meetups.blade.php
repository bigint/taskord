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
                    <x-empty icon="handshake" text="No meetups found" />
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
