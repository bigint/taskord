@extends('layouts.app')

@section('pageTitle', 'Admin - Products ·')
@section('title', 'Admin - Products ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="container-md">
            @include('admin.nav')
            @livewire('admin.products')
        </div>
    </div>
</div>
@endsection
