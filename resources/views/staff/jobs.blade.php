@extends('layouts.app')

@section('pageTitle', 'Stafftool - Jobs ·')
@section('title', 'Stafftool - Jobs ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="container-md">
                @include('staff.nav')
                <div class="card">
                    <iframe src="horizon" style="height:75vh">
                </div>
            </div>
        </div>
    </div>
@endsection
