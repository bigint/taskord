@extends('layouts.app')

@section('pageTitle', 'Milestones ·')
@section('title', 'Milestones ·')
@section('description', 'Browse milestones.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="pb-2 h5">
                    <x-heroicon-o-truck class="heroicon-2x ms-1 text-secondary" />
                    Milestones
                </div>
                @livewire('milestone.milestones', [
                    'type' => $type,
                    'page' => 1,
                    'perPage' => 10
                ])
            </div>
            <div class="col-sm">
                <x-footer />
            </div>
        </div>
    </div>
@endsection
