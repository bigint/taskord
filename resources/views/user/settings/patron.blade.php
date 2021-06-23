@extends('layouts.app')

@section('pageTitle', 'Settings / Patron ·')

@section('content')
    <div class="container-md">
        <div class="row justify-content-center mt-4">
            @include('user.settings.sidebar')
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <span class="h5">Patron</span>
                        <div>Thanks for showing us your support!</div>
                    </div>
                    <div class="card-body">
                        @if (!$user->is_patron)
                            <a class="btn btn-outline-success rounded-pill" href="{{ route('patron.home') }}">
                                Support now!
                            </a>
                        @else
                            @if ($user->patron)
                                <div>
                                    <div>
                                        <span class="fw-bold">Checkout ID:</span>
                                        <span
                                            class="text-danger fw-bold font-monospace">{{ $user->patron->checkout_id }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Subscribed to:</span>
                                        @if ($user->patron->subscription_plan_id === 619848)
                                            <span>Tier 1</span>
                                        @elseif ($user->patron->subscription_plan_id === 621377)
                                            <span>Tier 2</span>
                                        @elseif ($user->patron->subscription_plan_id === 621379)
                                            <span>Tier 3</span>
                                        @elseif ($user->patron->subscription_plan_id === 621380)
                                            <span>Tier 4</span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="fw-bold">Subscribed at:</span>
                                        <span>{{ carbon($user->patron->created_at)->format('d M Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Last transaction:</span>
                                        <span>{{ carbon($user->patron->event_time)->format('d M Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Next bill date:</span>
                                        <span>{{ carbon($user->patron->next_bill_date)->format('d M Y') }}</span>
                                    </div>
                                    <div class="mt-2">
                                        @if ($user->patron->update_url)
                                            <a class="btn btn-outline-success rounded-pill"
                                                href="{{ $user->patron->update_url }}" target="_blank" rel="noreferrer">
                                                <x-heroicon-o-pencil class="heroicon" />
                                                Update Payment
                                            </a>
                                        @endif
                                        @if ($user->patron->cancel_url)
                                            <a class="btn btn-outline-danger rounded-pill"
                                                href="{{ $user->patron->cancel_url }}" target="_blank" rel="noreferrer">
                                                <x-heroicon-o-x class="heroicon" />
                                                Cancel Patron
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div>You are using gifted account!</div>
                                <a class="btn btn-outline-success rounded-pill mt-2" href="{{ route('patron.home') }}">
                                    Support now!
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
