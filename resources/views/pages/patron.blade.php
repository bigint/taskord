@extends('layouts.app')

@section('content')
<div class="container">
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
                <div class="col-md-8">
                    <div class="font-weight-bold mb-3">You get the following benefits</div>
                    <ul>
                        <li>❤️ Good karma for helping a bootstrapped startup</li>
                        <li>💰 Financially commit to staying productive</li>
                        <li>🔥 Enable Dark Mode on the website</li>
                        <li>💎 Show off your support with the Patron badge</li>
                        <li>🔒 Make your tasks private</li>
                        <li>👍 Fund on-going development of the platform</li>
                    </ul>
                </div>
                <div class="col-sm">
                    @auth
                    @if (Auth::user()->isPatron)
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
