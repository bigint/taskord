@extends('layouts.app')

@section('pageTitle', $product->name.' ·')
@section('title', $product->name.' ·')
@section('description', $product->description)
@section('image', $product->avatar)
@section('url', url()->current())

@section('content')
<div class="container">
    @include('product.profile')
    <div class="row justify-content-center mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @auth
                    @if (Auth::id() === $product->user->id && !$product->user->isFlagged)
                        @livewire('create-task', [
                            'type' => 'product',
                            'product_id' => $product->id,
                        ])
                    @endif
                    @endauth
                    @livewire('product.tasks', [
                        'type' => 'product.done',
                        'product' => $product,
                        'page' => 1,
                    ])
                </div>
                @include('product.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
