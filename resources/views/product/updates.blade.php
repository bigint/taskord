@extends('layouts.app')

@section('pageTitle', $product->name . ' / Updates ·')
@section('title', $product->name . ' / Updates ·')
@section('description', $product->description)
@section('image', $product->avatar)
@section('url', url()->current())

@section('content')
    <div class="container-md">
        @include('product.profile')
        <div class="row justify-content-center mt-4">
            <div class="col-lg-8">
                @livewire('product.updates', [
                'product' => $product,
                ])
            </div>
            @include('product.sidebar')
        </div>
    </div>
@endsection
