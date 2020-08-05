@extends('layouts.app')

@section('content')
<div class="container">
    @include('product.profile')
    <div class="row justify-content-center mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if (Auth::check() && Auth::id() === $product->user->id && !$product->user->isFlagged)
                        @livewire('create-task')
                    @endif
                    @livewire('product.tasks', [
                        'type' => 'product.done',
                        'product' => $product,
                        'page' => 1,
                        'perPage' => 3
                    ])
                </div>
                @include('product.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
