@extends('layouts.app')

@section('pageTitle', $product->name.' / Pending ·')
@section('title', $product->name.' / Pending ·')
@section('description', $product->description)
@section('image', $product->avatar)
@section('url', url()->current())

@section('content')
<div class="container">
    @include('product.profile')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            @auth
            @if (
                Auth::id() === $product->owner->id or
                $product->members->contains(Auth::id()) &&
                !$product->owner->isFlagged
            )
                @livewire('create-task', [
                    'type' => 'product',
                    'product_id' => $product->id,
                ])
            @endif
            @endauth
            @livewire('product.tasks', [
                'type' => 'product.pending',
                'product' => $product,
                'page' => 1,
            ])
        </div>
        @include('product.sidebar')
    </div>
</div>
@endsection
