@extends('layouts.app')

@section('pageTitle', 'Admin - Tasks ·')
@section('title', 'Admin - Tasks ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="container-md">
            @include('admin.nav')
            <div class="card" wire:init="loadTasks">
                <div class="card-header h6 pt-3 pb-3">
                    <div class="h5">System Info</div>
                    Taskord's system info
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header fw-bold">
                            Disk Info
                        </div>
                        <div class="card-body">
                            <div>
                                <span class="fw-bold">Total Storage: </span>
                                <span>{{ $ds }}</span>
                            </div>
                            <div>
                                <span class="fw-bold">Disk used: </span>
                                <span>{{ $du }}</span>
                            </div>
                            <div>
                                <span class="fw-bold">Disk available: </span>
                                <span>{{ $df }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
