@extends('layouts.app')

@section('pageTitle', $product->name.' / Updates ·')
@section('title', $product->name.' / Updates ·')
@section('description', $product->description)
@section('image', $product->avatar)
@section('url', url()->current())

@section('content')
<div class="container">
    @include('product.profile')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            @livewire('product.updates', [
                'product' => $product,
            ])
        </div>
        @include('product.sidebar')
    </div>
</div>
@endsection
