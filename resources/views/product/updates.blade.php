@extends('layouts.app')

@section('pageTitle', $product->name.' / Updates · ')

@section('content')
<div class="container">
    @include('product.profile')
    <div class="row justify-content-center mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @livewire('product.updates', [
                        'product' => $product,
                    ])
                </div>
                @include('product.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
