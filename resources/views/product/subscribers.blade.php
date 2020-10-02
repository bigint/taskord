@extends('layouts.app')

@section('pageTitle', $product->name.' / Subscribers ·')
@section('title', $product->name.' / Subscribers ·')
@section('description', $product->description)
@section('image', $product->avatar)
@section('url', url()->current())

@section('content')
<div class="container">
    @include('user.profile')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            @livewire('user.followers', ['user' => $user])
        </div>
        @include('user.sidebar')
    </div>
</div>
@endsection
