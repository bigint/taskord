@extends('layouts.app')

@section('pageTitle', 'Search ·')
@section('title', 'Search ·')
@section('description', 'Browse questions and discuss, answer, give feedbacks, etc.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="h4 fw-normal d-flex align-items-center">
                    <x-heroicon-o-search class="heroicon heroicon-20px" />
                    <span class="ms-2">
                        Search more than
                        <span class="fw-bold">{{ $random }}</span>
                    </span>
                </div>
                <form action="/search/tasks" method="GET" role="search">
                    @csrf
                    <div class="input-group mt-3">
                        <input type="text" class="form-control" name="q" placeholder="Search Taskord" autofocus>
                        <button type="submit" class="btn btn-secondary">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <x-bottom-footer />
    </div>
@endsection
