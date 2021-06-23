@extends('layouts.app')

@section('pageTitle', $product->name . ' ·')
@section('title', $product->name . ' ·')
@section('description', $product->description)
@section('image', $product->avatar)
@section('url', url()->current())

@section('content')
    <div class="container-md">
        @include('product.profile')
        <div class="row justify-content-center mt-4">
            <div class="col-lg-8">
                @auth
                    @if (auth()->user()->id === $product->user->id or $product->members->contains(auth()->user()->id) && !$product->user->spammy)
                        <div class="card mb-3">
                            <div class="card-body">
                                <livewire:create-task :product="$product" />
                            </div>
                        </div>
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
@endsection
