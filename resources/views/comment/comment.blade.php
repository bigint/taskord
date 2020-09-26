@extends('layouts.app')

@section('pageTitle', $task->task.' ·')
@section('title', 'Task by @'.$task->user->username.' ·')
@section('description', $task->task)
@section('image', $task->user->avatar)
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            Yo
        </div>
    </div>
</div>
@endsection
