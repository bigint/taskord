@extends('layouts.app')

@section('pageTitle', 'Search ·')
@section('title', 'Search ·')
@section('description', 'Browse questions and discuss, answer, give feedbacks, etc.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    Soon
                </div>
                <div class="col-md-8">
                    <form action="/search/tasks" method="GET" role="search">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Search users">
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
