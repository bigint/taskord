@extends('layouts.app')

@section('pageTitle', 'Products · New')

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            @auth
                @if (!auth()->user()->isFlagged)
                @livewire('products.create-product')
                @else
                <div class="text-center">
                    <div class="alert alert-danger" role="alert">
                        You can't create new product, because your account has been flagged 😢
                    </div>
                    <a class="btn btn-primary" href="{{ route('home') }}">Go to home</a>
                </div>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection
