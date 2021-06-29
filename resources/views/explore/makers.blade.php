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
            <div class="col-lg-9 pt-4">
                <h5>Featured makers</h5>
                <div class="card">
                    <livewire:explore.featured-makers />
                </div>
            </div>
            <x-bottom-footer />
        </div>
    </div>
@endsection
