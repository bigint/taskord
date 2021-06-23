@extends('layouts.app')

@section('pageTitle', 'Meetups ·')
@section('title', 'Meetups ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @include('meetups.nav')
                @livewire('meetups.meetups', [
                'type' => $type,
                'page' => 1,
                'perPage' => 10
                ])
            </div>
            <div class="col-sm">
                <div class="card mb-4">
                    <div class="card-body">
                        WIP
                    </div>
                </div>
                <x-footer />
            </div>
        </div>
    </div>
@endsection
