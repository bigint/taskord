<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#343a40">
    <meta name="description" content="@yield('description')">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@taskord">
    <meta property="og:logo" content="/images/logo.svg">
    <meta property="og:site_name" content="Taskord">
    <meta property="og:title" content="@yield('title') Taskord">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:image" content="@yield('image')">
    <meta property="og:url" content="@yield('url')">
    <meta property="og:type" content="article">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>@yield('pageTitle') Taskord</title>
    <link rel="icon" href="/images/logo.svg" sizes="any" type="image/svg+xml">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" data-turbolinks-track="true">
    <script type="text/javascript">
        (function() {
            var css = document.createElement('link');
            css.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css';
            css.rel = 'stylesheet';
            css.type = 'text/css';
            document.getElementsByTagName('head')[0].appendChild(css);
        })();
    </script>
    @auth
    @if (Auth::user()->isPatron or Auth::user()->isStaff)
    @if (Auth::user()->darkMode)
    <link href="{{ mix('css/darkmode.css') }}" rel="stylesheet" data-turbolinks-track="true">
    @endif
    @endif
    @endauth
    @livewireStyles
</head>
<body>
    <div id="app">
        @auth
        @if (Auth::user()->isStaff)
            @if (Auth::user()->staffShip)
            <div class="admin-bar">
                @livewire('admin.adminbar')
            </div>
            @endif
        @endif
        @endauth
        @include('layouts.navbar')
        @if (session()->has('global'))
            <div class="alert alert-success alert-dismissible fade show rounded-0 mb-0">
                <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
                <i class="fa fa-check me-1"></i>
                {{ session('global') }}
            </div>
        @endif
        @auth
        @if (Auth::user()->isFlagged)
        <div class="alert alert-danger rounded-0" role="alert">
            <div class="fw-bold">
                <i class="fa fa-flag me-1"></i>
                Your account has been flagged.
            </div>
            <div class="mt-1">
                Because of that, your profile will be hidden from the public. If you believe this is a mistake, <a href="https://forms.clickup.com/f/357rd-767/8PPJM0SN435CWUX4X2" target="_blank">contact support</a> to have your account status reviewed.
            </div>
        </div>
        @endif
        @if (!Auth::user()->hasVerifiedEmail())
        <div class="alert alert-warning rounded-0" role="alert">
            <div class="fw-bold">
                <i class="fa fa-envelope me-1"></i>
                Verify Your Email Address <x-beta background="light" />
            </div>
            <form class="mt-1" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                Before proceeding, please check your email for a verification link. If you did not receive the email,
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">click here to request another</button>.
            </form>
        </div>
        @endif
        @endauth
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
@livewireScripts
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer data-turbolinks-track="true" data-turbolinks-eval=false></script>
<script src="{{ asset('js/app.js', config('app.env') === 'production' ? true : false) }}" defer data-turbolinks-track="true" data-turbolinks-eval=false></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178044316-1" data-turbolinks-track="true" data-turbolinks-eval=false></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-178044316-1');
</script>
</html>
