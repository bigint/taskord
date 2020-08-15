@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            @livewire('product.edit-product', [
                'product' => $product
            ])
        </div>
    </div>
</div>
@endsection
