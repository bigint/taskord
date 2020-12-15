@extends('layouts.app')

@section('pageTitle', 'Products / Newest ·')
@section('title', 'Products / Newest ·')
@section('description', 'Public products available in Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @if (session()->has('product_deleted'))
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
                    <i class="fa fa-check me-1"></i>
                    {{ session('product_deleted') }}
                </div>
            @endif
            @include('products.nav')
            @livewire('products.products', [
                'type' => 'products.newest',
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
@endsection
