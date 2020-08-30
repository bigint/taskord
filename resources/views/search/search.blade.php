@extends('layouts.app')

@section('pageTitle', 'Search ·')
@section('title', 'Search ·')
@section('description', 'Browse questions and discuss, answer, give feedbacks, etc.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="h4 font-weight-normal">
                <i class="fa fa-search mr-2"></i>
                <span>
                    Search more than
                    <span class="font-weight-bold">{{ $random }}</span>
                </span>
            </div>
            <form action="/search/tasks" method="GET" role="search">
                @csrf
                <div class="input-group mt-3">
                    <input type="text" class="form-control" name="q" placeholder="Search Taskord">
                    <button type="submit" class="btn btn-secondary">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
