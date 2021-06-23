@extends('layouts.app')

@section('pageTitle', 'Explore ·')
@section('title', 'Explore ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', 'https://ik.imagekit.io/taskordimg/cover_i8r6XmiSW.png')
@section('url', url()->current())

@section('content')
    @include('explore.nav')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8 pt-4">
                <div class="card">
                    <div class="card-body">
                        WIP
                    </div>
                </div>
            </div>
            <x-bottom-footer />
        </div>
    </div>
@endsection
