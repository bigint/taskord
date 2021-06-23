@extends('layouts.app')

@section('pageTitle', 'Stafftool - Features ·')
@section('title', 'Stafftool - Features ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="container-md">
                @include('staff.nav')
                <livewire:staff.features.features />
            </div>
        </div>
    </div>
@endsection
