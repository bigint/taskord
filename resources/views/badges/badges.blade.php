@extends('layouts.app')

@section('pageTitle', 'Badges ·')
@section('title', 'Badges ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @livewire('badges.badges', [
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
                @can('staff.ops')
                    <div class="card mb-4">
                        <div class="card-body">
                            <a type="button" class="btn btn-outline-success rounded-pill" href="{{ route('badges.new') }}">
                                <x-heroicon-o-plus class="heroicon" />
                                Add new badge
                            </a>
                        </div>
                    </div>
                @endcan
                <x-footer />
            </div>
        </div>
    </div>
@endsection
