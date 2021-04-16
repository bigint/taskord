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
            <div class="card">
                <div class="card-header h6 pt-3 pb-3">
                    <div class="h5">System Info</div>
                    Taskord's system info
                </div>
                <div class="card-body row-col-2">
                    <div class="row">
                        <div class="col-md mb-3">
                            <div class="card">
                                <div class="card-header fw-bold">
                                    Disk Info
                                </div>
                                <div class="card-body">
                                    <div>
                                        <span class="fw-bold">Total: </span>
                                        <span>{{ formatBytes(disk_total_space('/')) }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Used: </span>
                                        <span>{{ formatBytes(disk_total_space('/') - disk_free_space('/')) }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Available: </span>
                                        <span>{{ formatBytes(disk_free_space('/')) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md mb-3">
                            <div class="card">
                                <div class="card-header fw-bold">
                                    Memory Info
                                </div>
                                <div class="card-body">
                                    <div>
                                        <span class="fw-bold">Total: </span>
                                        <span>{{ formatBytes(floatval($meminfo['MemTotal']) * 1024) }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Free: </span>
                                        <span>{{ formatBytes(floatval($meminfo['MemFree']) * 1024) }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Available: </span>
                                        <span>{{ formatBytes(floatval($meminfo['MemAvailable']) * 1024) }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Cached: </span>
                                        <span>{{ formatBytes(floatval($meminfo['Cached']) * 1024) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
