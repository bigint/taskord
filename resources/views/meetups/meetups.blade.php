@extends('layouts.app')

@section('pageTitle', 'Meetups ·')
@section('title', 'Meetups ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Meetups</span>
            <div>Meet and greet.</div>
        </div>
        <div class="card-body">
            @if (count($meetups) === 0)
            <x-empty icon="gifts" text="No meetups found" />
            @endif
        </div>
    </div>
</div>
@endsection
