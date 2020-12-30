@extends('layouts.app')

@section('pageTitle', 'Admin - Users ·')
@section('title', 'Admin - Users ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="container-md">
            @include('admin.nav')
            @livewire('admin.users')
        </div>
    </div>
</div>
@endsection
