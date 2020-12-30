@extends('layouts.app')

@section('pageTitle', 'Products / Launched ·')
@section('title', 'Products / Launched ·')
@section('description', 'Public products available in Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @include('products.nav')
            @livewire('products.products', [
                'type' => 'products.launched',
                'page' => 1,
                'perPage' => 1
            ])
        </div>
        <div class="col-sm">
            @livewire('products.active-products')
            <x-footer />
        </div>
    </div>
</div>
@endsection
