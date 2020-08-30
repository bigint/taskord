@extends('layouts.app')

@section('pageTitle', 'Deals ·')
@section('title', 'Deals ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Deals</span>
            <div>Discounts and special deals for Taskord members. Only available for patrons.</div>
            <div>
                <a href="artable link" target="_blank">Add your product</a>
            </div>
            @auth
            @if (Auth::user()->staffShip)
            <button type="button" class="mt-2 btn btn-success text-white" data-toggle="modal" data-target="#newQuestionModal">
                <i class="fa fa-plus mr-1"></i>
                Add a Deal
            </button>
            @livewire('pages.create-deal')
            @endif
            @endauth
        </div>
        <div class="card-body">
            @foreach ($deals as $deal)
                <div class="d-flex align-items-center {{ $loop->last ? '' : 'mb-5' }}">
                    <div>
                        <img class="rounded avatar-100" src="{{ $deal->logo }}" />
                    </div>
                    <div class="ml-3">
                        <span class="h4">
                            {{ $deal->name }}
                        </span>
                        <span class="h5">
                            <span class="align-text-top badge bg-success font-weight-normal p-1 ml-1">{{ $deal->offer }}% OFF</span>
                        </span>
                        <div class="h6 mt-3">{{ $deal->description }}</div>
                        <div class="mt-2">
                            <a href="{{ $deal->website }}" target="_blank">{{ $deal->website }}</a>
                        </div>
                        @auth
                        @if (Auth::user()->isPatron)
                        <div class="mt-2">
                            Coupon Code
                            <code class="ml-2 font-weight-bold">
                                {{ $deal->coupon }}
                            </code>
                        </div>
                        @else
                        <div class="mt-2">
                            <a class="text-black-50" href="{{ route('patron.home') }}">You must be a patron to see coupon code.</a>
                        </div>
                        @endif
                        @endauth
                        @guest
                        <div class="mt-2">
                            <a class="text-black-50" href="{{ route('login') }}">Login to view coupon code.</a>
                        </div>
                        @endguest
                        @auth
                        @if (Auth::user()->staffShip)
                            <div class="mt-3">
                                <code>
                                    Deal::find({{ $deal->id }})->delete()
                                </code>
                            </div>
                        @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
