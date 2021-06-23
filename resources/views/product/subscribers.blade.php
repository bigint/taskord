@extends('layouts.app')

@section('pageTitle', $product->name . ' / Subscribers ·')
@section('title', $product->name . ' / Subscribers ·')
@section('description', $product->description)
@section('image', $product->avatar)
@section('url', url()->current())

@section('content')
    <div class="container-md">
        @include('product.profile')
        <div class="row justify-content-center mt-4">
            <div class="col-lg-8">
                @livewire('product.subscribers', [
                'product' => $product,
                ])
            </div>
            @include('product.sidebar')
        </div>
    </div>
@endsection
