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
            @livewire('admin.activities')
        </div>
    </div>
</div>
@endsection
