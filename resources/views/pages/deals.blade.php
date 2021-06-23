@extends('layouts.app')

@section('pageTitle', 'Deals ·')
@section('title', 'Deals ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="card">
            <div class="card-header py-3">
                <span class="h5">Deals</span>
                <div>Discounts and special deals for Taskord members. Only available for patrons.</div>
                <div>
                    <a href="https://tally.so/r/63l4o3" target="_blank" rel="noreferrer">Add your product</a>
                </div>
                @can('staff.ops')
                    <button type="button" class="mt-2 btn btn-outline-success rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#newQuestionModal">
                        <x-heroicon-o-plus class="heroicon" />
                        Add a Deal
                    </button>
                    <livewire:pages.create-deal />
                @endcan
            </div>
            <div class="card-body">
                @if (count($deals) === 0)
                    <div class="card-body text-center mt-3 mb-3">
                        <x-heroicon-o-gift class="heroicon heroicon-60px text-primary mb-2" />
                        <div class="h4">
                            No deals found
                        </div>
                    </div>
                @endif
                @foreach ($deals as $deal)
                    <div class="d-flex align-items-center {{ $loop->last ? '' : 'mb-5' }}">
                        <div>
                            <img loading=lazy class="rounded avatar-100" src="{{ $deal->logo }}" height="100" width="100"
                                alt="{{ $deal->name }}'s Logo" />
                        </div>
                        <div class="ms-4">
                            <span class="h4">
                                {{ $deal->name }}
                            </span>
                            <span class="h5">
                                <span class="align-text-top badge bg-success ms-1">{{ $deal->offer }}% OFF</span>
                            </span>
                            <div class="h6 mt-3">{{ $deal->description }}</div>
                            <div class="mt-2">
                                <a href="{{ $deal->website }}" target="_blank">{{ $deal->website }}</a>
                            </div>
                            @auth
                                @if (auth()->user()->is_patron)
                                    @if ($deal->coupon)
                                        <div class="mt-2">
                                            Coupon Code
                                            <code class="ms-2 fw-bold">
                                                {{ $deal->coupon }}
                                            </code>
                                        </div>
                                    @else
                                        <div class="mt-2 fw-bold">
                                            <a href="{{ $deal->referral }}" target="_blank">
                                                Click here to get your deal
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <div class="mt-2">
                                        <a class="text-secondary" href="{{ route('patron.home') }}">You must be a patron to
                                            see coupon code.</a>
                                    </div>
                                @endif
                            @endauth
                            @guest
                                <div class="mt-2">
                                    <a class="text-secondary" href="{{ route('login') }}">Login to view coupon code.</a>
                                </div>
                            @endguest
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
