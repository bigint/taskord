@extends('layouts.app')

@section('pageTitle', 'New Milestone ·')

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                @auth
                    @if (!auth()->user()->spammy)
                        <livewire:milestone.edit-milestone :milestone="$milestone" />
                    @else
                        <div class="text-center">
                            <div class="alert alert-danger" role="alert">
                                You can't edit this milestone, because your account has been flagged 😢
                            </div>
                            <a class="btn btn-outline-primary rounded-pill" href="{{ route('home') }}">Go to home</a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    <x-bottom-footer />
@endsection
