@extends('layouts.app')

@section('pageTitle', 'Meetups ·')
@section('title', 'Meetups ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header pt-3 pb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="h5">Meetups</div>
                    <div>Meet and greet.</div>
                </div>
                <div>
                    <button class="btn btn-outline-primary">
                        Upcoming
                    </button>
                    <button class="btn btn-outline-primary">
                        Finished
                    </button>
                    @auth
                    <button class="btn btn-success text-white">
                        <i class="fa fa-plus mr-1"></i>
                        New Meetup
                    </button>
                    @endauth
                </div>
            </div>
        </div>
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
