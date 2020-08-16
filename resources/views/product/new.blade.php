@extends('layouts.app')

@section('pageTitle', 'New Product ·')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            @livewire('product.new-product')
        </div>
    </div>
</div>
@endsection
