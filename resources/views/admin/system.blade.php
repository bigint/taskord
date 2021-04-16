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
                        <div class="col-md">
                            <div class="card">
                                <div class="card-header fw-bold">
                                    Disk Info
                                </div>
                                <div class="card-body">
                                    <div>
                                        <span class="fw-bold">Total Storage: </span>
                                        <span>{{ formatBytes(disk_total_space('/')) }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Disk used: </span>
                                        <span>{{ formatBytes(disk_total_space('/') - disk_free_space('/')) }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Disk available: </span>
                                        <span>{{ formatBytes(disk_free_space('/')) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="card">
                                <div class="card-header fw-bold">
                                    Memory Info
                                </div>
                                <div class="card-body">
                                    <div>
                                        <span class="fw-bold">Total Storage: </span>
                                        <span>{{ formatBytes(memory_get_usage()) }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Disk used: </span>
                                        <span>{{ formatBytes(memory_get_usage()) }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Disk available: </span>
                                        <span>{{ formatBytes(memory_get_usage()) }}</span>
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
