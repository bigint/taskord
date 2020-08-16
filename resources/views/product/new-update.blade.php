@extends('layouts.app')

@section('pageTitle', $product->name.' / New Update ·')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            @livewire('product.new-update', [
                'product' => $product
            ])
        </div>
    </div>
</div>
@endsection
