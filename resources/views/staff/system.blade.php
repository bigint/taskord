@extends('layouts.app')

@section('pageTitle', 'Stafftool - System ·')
@section('title', 'Stafftool - System ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="container-md">
            @include('staff.nav')
            <div class="card">
                <div class="card-header h6 py-3">
                    <div class="h5">System Info</div>
                    Taskord's system info
                </div>
                <div class="card-body">
                    <h5 class="mb-3">System</h4>
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-header fw-bold d-flex align-items-center">
                                    <x-heroicon-o-database class="heroicon me-1" />
                                    <span>Disk usage</span>
                                </div>
                                <div class="card-body">
                                    <div class="h5 mb-0">
                                        {{ formatBytes(disk_total_space('/') - disk_free_space('/')) }} / {{ formatBytes(disk_total_space('/')) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-header fw-bold d-flex align-items-center">
                                    <x-heroicon-o-cog class="heroicon me-1" />
                                    <span>Memory usage</span>
                                </div>
                                <div class="card-body">
                                    <div class="h5 mb-0">
                                        {{ formatBytes(floatval($meminfo['Active']) * 1024) }} / {{ formatBytes(floatval($meminfo['MemTotal']) * 1024) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-header fw-bold d-flex align-items-center">
                                    <x-heroicon-o-lightning-bolt class="heroicon me-1" />
                                    <span>Cached memory</span>
                                </div>
                                <div class="card-body">
                                    <div class="h5 mb-0">
                                        {{ formatBytes(floatval($meminfo['Cached']) * 1024) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-header fw-bold d-flex align-items-center">
                                    <x-heroicon-o-chip class="heroicon me-1" />
                                    <span>CPUs</span>
                                </div>
                                <div class="card-body">
                                    <div class="h5 mb-0">
                                        {{ $ncpu }} vCPUs
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-header fw-bold d-flex align-items-center">
                                    <x-heroicon-o-clock class="heroicon me-1" />
                                    <span>Uptime</span>
                                </div>
                                <div class="card-body">
                                    <div class="h5 mb-0">
                                        {{ $uptime }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="mb-3 mt-4">Database</h4>
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-header fw-bold d-flex align-items-center">
                                    <x-heroicon-o-database class="heroicon me-1" />
                                    <span>Database size</span>
                                </div>
                                <div class="card-body">
                                    <div class="h5 mb-0">
                                        WIP 🚧
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-header fw-bold d-flex align-items-center">
                                    <x-heroicon-o-table class="heroicon me-1" />
                                    <span>Total rows</span>
                                </div>
                                <div class="card-body">
                                    <div class="h5 mb-0">
                                        WIP 🚧
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
