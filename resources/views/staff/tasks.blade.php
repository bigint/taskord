@extends('layouts.app')

@section('pageTitle', 'Stafftool - Tasks ·')
@section('title', 'Stafftool - Tasks ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="container-md">
                @include('staff.nav')
                <livewire:staff.tasks />
            </div>
        </div>
    </div>
@endsection
