@extends('layouts.app')

@section('pageTitle', 'Open ·')
@section('title', 'Open ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <div class="container-md">
        <div class="card">
            <div class="card-header py-3">
                <span class="h5">Open</span>
                <div>Analytics of Taskord</div>
            </div>
            <div class="card-body">
                <livewire:pages.open.all-tasks />
                <livewire:pages.open.completed-tasks />
                <livewire:pages.open.reputations />
            </div>
        </div>
    </div>
@endsection
