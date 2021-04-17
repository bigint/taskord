@extends('layouts.app')

@section('pageTitle', 'Admin - Stats ·')
@section('title', 'Admin - Stats ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="container-md">
            @include('admin.nav')
            @livewire('admin.stats')
        </div>
    </div>
</div>
@endsection
