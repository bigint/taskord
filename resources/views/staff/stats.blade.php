@extends('layouts.app')

@section('pageTitle', 'Stafftool - Stats ·')
@section('title', 'Stafftool - Stats ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="container-md">
                @include('staff.nav')
                <livewire:staff.stats />
            </div>
        </div>
    </div>
@endsection
