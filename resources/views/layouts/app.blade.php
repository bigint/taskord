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
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @laravelPWA
    @auth
    @if (auth()->user()->isPatron or auth()->user()->isStaff)
    @if (auth()->user()->darkMode)
    <link href="{{ mix('css/darkmode.css') }}" rel="stylesheet">
    @endif
    @endif
    @endauth
    <livewire:styles />
    @if (App::environment() === 'production')
    <script async src="https://cdn.splitbee.io/sb.js"></script>
    @endif
</head>
<body>
    <div id="app">
        @auth
        @if (auth()->user()->isStaff)
            @if (auth()->user()->staffShip)
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
                <x-heroicon-o-check class="heroicon" />
                {{ session('global') }}
            </div>
        @endif
        @auth
        @if (auth()->user()->isFlagged)
        <div class="alert alert-danger rounded-0" role="alert">
            <div class="fw-bold">
                <x-heroicon-o-flag class="heroicon" />
                Your account has been flagged.
            </div>
            <div class="mt-1">
                Because of that, your profile will be hidden from the public. If you believe this is a mistake, <a href="https://forms.clickup.com/f/357rd-767/8PPJM0SN435CWUX4X2" target="_blank" rel="noreferrer">contact support</a> to have your account status reviewed.
            </div>
        </div>
        @endif
        @if (!auth()->user()->hasVerifiedEmail())
        <div class="alert alert-warning rounded-0" role="alert">
            <div class="fw-bold">
                <x-heroicon-o-mail class="heroicon" />
                Verify Your Email Address <x-beta background="light" />
            </div>
            <form class="mt-1" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                Before proceeding, please check your email for a verification link. If you did not receive the email,
                <button type="submit" class="align-baseline btn m-0 p-0 rm-shadow text-primary">click here to request another</button>.
            </form>
        </div>
        @endif
        @endauth
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<livewire:scripts />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10" defer></script>
<x-livewire-alert::scripts />
<script src="{{ mix('js/bootstrap.js') }}" defer></script>
<script src="{{ mix('js/app.js') }}" defer></script>
@yield('scripts')
</html>
