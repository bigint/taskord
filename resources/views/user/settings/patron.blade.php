@extends('layouts.app')

@section('pageTitle', 'Settings / Patron ·')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">
        @include('user.settings.sidebar')
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header pt-3 pb-3">
                    <span class="h5">Patron</span>
                    <div>Thanks for showing us your support!</div>
                </div>
                <div class="card-body">
                    @if (!$user->isPatron)
                        <a class="btn btn-success text-white" href="{{ route('patron.home') }}">
                            Support now!
                        </a>
                    @else
                        @if ($user->patron)
                        <div>
                            <div>
                                <span class="font-weight-bold">Checkout ID:</span>
                                <code class="fa-1x">{{ $user->patron->checkout_id }}</code>
                            </div>
                            <div>
                                <span class="font-weight-bold">Subscribed to:</span>
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
                                <span class="font-weight-bold">Subscribed at:</span>
                                <span>{{ Carbon::parse($user->patron->created_at)->format('d M Y') }}</span>
                            </div>
                            <div>
                                <span class="font-weight-bold">Last transaction:</span>
                                <span>{{ Carbon::parse($user->patron->event_time)->format('d M Y') }}</span>
                            </div>
                            <div>
                                <span class="font-weight-bold">Next bill date:</span>
                                <span>{{ Carbon::parse($user->patron->next_bill_date)->format('d M Y') }}</span>
                            </div>
                            <div class="mt-2">
                                @if ($user->patron->update_url)
                                <a class="btn btn-success text-white" href="{{ $user->patron->update_url }}" target="_blank">
                                    <i class="fa fa-pen mr-1"></i>
                                    Update Payment
                                </a>
                                @endif
                                @if ($user->patron->cancel_url)
                                <a class="btn btn-danger" href="{{ $user->patron->cancel_url }}" target="_blank">
                                    <i class="fa fa-times mr-1"></i>
                                    Cancel Patron
                                </a>
                                @endif
                            </div>
                        </div>
                        @else
                            <div>You are using gifted account!</div>
                            <a class="btn btn-success text-white mt-2" href="{{ route('patron.home') }}">
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
