@extends('layouts.app')

@section('pageTitle', 'Admin - Stats ·')
@section('title', 'Admin - Stats ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            @include('admin.sidebar')
            <div class="card">
                <div class="card-header">
                    Featured
                </div>
                <div class="card-body">
                    WIP
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
