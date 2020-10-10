@extends('layouts.app')

@section('pageTitle', 'Patron ·')
@section('title', 'Patron ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-md">
    <div class="mb-4 text-center">
        <img src="/images/patron.svg" width="100" />
    </div>
    <div class="card">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Become a Patron</span>
            <div>Support Taskord by becoming a Patron.</div>
        </div>
        <div class="card-body">
            <div class="row align-items-center font-monospace">
                <div class="col-lg-8">
                    <div class="font-weight-bold mb-3">You get the following benefits</div>
                    <ul>
                        <li>🌑 Enable Awesome Dark Mode</li>
                        <li>💬 Patrons only discussion to make it more meaningful</li>
                        <li>🔒 Make your tasks private and get personal things done</li>
                        <li>🤝 Show off your support with the Patron badge</li>
                        <li>👍 Fund on-going development of the platform and server fee</li>
                        <li>More coming soon...</li>
                    </ul>
                </div>
                <div class="col-sm">
                    @auth
                    @if (Auth::user()->isPatron and Auth::user()->patron()->count() === 1)
                    <div class="text-center">
                        <div class="h5">
                            {{ Emoji::redHeart() }}
                            You are already a patron!
                        </div>
                        <a class="text-primary" href="{{ route('user.settings.patron') }}">
                            Go to settings
                        </a>
                    </div>
                    @else
                    <a
                        class="paddle_button btn btn-block btn-primary"
                        data-theme="none"
                        data-product="619848"
                        data-message="Support $5/month for Taskord!"
                        data-email="{{ Auth::user()->email }}"
                    >
                        Support $5/month
                    </a>
                    <a
                        class="paddle_button btn btn-block btn-primary"
                        data-theme="none"
                        data-product="621377"
                        data-message="Support $10/month for Taskord!"
                        data-email="{{ Auth::user()->email }}"
                    >
                        Support $10/month
                    </a>
                    <a
                        class="paddle_button btn btn-block btn-primary"
                        data-theme="none"
                        data-product="621379"
                        data-message="Support $20/month for Taskord!"
                        data-email="{{ Auth::user()->email }}"
                    >
                        Support $20/month
                    </a>
                    <a
                        class="paddle_button btn btn-block btn-primary"
                        data-theme="none"
                        data-product="621380"
                        data-message="Support $50/month for Taskord!"
                        data-email="{{ Auth::user()->email }}"
                    >
                        Support $50/month
                    </a>
                    <a
                        class="paddle_button btn btn-block btn-primary"
                        data-theme="none"
                        data-product="629491"
                        data-message="Support $100 onetime for lifetime pro in Taskord!"
                        data-email="{{ Auth::user()->email }}"
                    >
                        Support $100 onetime
                    </a>
                    @endif
                    @endauth
                    @guest
                    <a class="btn btn-block btn-success text-white" href="{{ route('login') }}">
                        Login to support!
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.paddle.com/paddle/paddle.js"></script>
<script type="text/javascript">
	Paddle.Setup({ vendor: 120187 });
</script>
@endsection
