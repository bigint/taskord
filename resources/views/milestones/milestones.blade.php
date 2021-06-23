@extends('layouts.app')

@if ($type === 'milestones.opened')
    @section('pageTitle', 'Milestones / Opened ·')
    @section('title', 'Milestones / Opened ·')
@else
    @section('pageTitle', 'Milestones / Closed ·')
    @section('title', 'Milestones / Closed ·')
@endif
@section('description', 'Browse milestones.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @include('milestones.nav')
                @livewire('milestone.milestones', [
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
