@extends('layouts.app')

@section('pageTitle', 'Products / Launched ·')
@section('title', 'Products / Launched ·')
@section('description', 'Public products available in Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @include('products.nav')
                    @livewire('products.products', [
                        'type' => 'products.launched',
                        'page' => 1,
                        'perPage' => 1
                    ])
                </div>
                <div class="col-sm">
                    @include('products.sidebar')
                    <x-footer />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
