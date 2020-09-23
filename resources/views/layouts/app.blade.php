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
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @auth
    @if (Auth::user()->isPatron or Auth::user()->isStaff)
    @if (Auth::user()->darkMode)
    <link href="{{ mix('css/darkmode.css') }}" rel="stylesheet">
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
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    @auth
                    @if (Auth::user()->isBeta)
                    <img src="/images/beta.svg" height="35" alt="">
                    @else
                    <img src="/images/logo.svg" height="35" alt="">
                    @endif
                    @endauth
                    @guest
                    <img src="/images/logo.svg" height="35" alt="">
                    @endguest
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @livewire('search')
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white font-weight-bold" href="{{ route('products.newest') }}">
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white font-weight-bold" href="{{ route('questions.newest') }}">
                                Questions
                            </a>
                        </li>
                        @auth
                        <li class="nav-item">
                            <a class="nav-link text-white font-weight-bold" href="{{ route('tasks') }}">
                                Tasks
                                <x-beta background="dark" />
                            </a>
                        </li>
                        @endauth
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white font-weight-bold" href="#" data-toggle="dropdown">
                                More
                            </a>
                            <ul class="dropdown-menu shadow-sm border" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item text-dark" href="{{ route('deals') }}">{{ Emoji::wrappedGift() }} Deals</a></li>
                                @auth
                                <li><a class="dropdown-item text-dark" href="{{ route('user.settings.integrations') }}">{{ Emoji::anchor() }} Integration</a></li>
                                @if (Auth::user()->staffShip)
                                <li><a class="dropdown-item text-dark" href="#">{{ Emoji::thinkingFace() }} Help</a></li>
                                <li><a class="dropdown-item text-dark" href="#">{{ Emoji::barChart() }} Open</a></li>
                                @endif
                                @endauth
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item mr-3">
                                <a class="nav-link text-white font-weight-bold" href="{{ route('login') }}">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white btn btn-primary font-weight-bold" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @else
                            @livewire('notification.icon')
                            <li class="nav-item mr-2">
                                <div class="nav-link">
                                    <span class="badge rounded-pill bg-warning text-dark reputation">
                                        {{ Emoji::fire() }} {{ number_format(Auth::user()->getPoints()) }}
                                    </span>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" href="#" role="button" data-toggle="dropdown" v-pre>
                                    <img class="rounded-circle avatar-30 mt-1" src="{{ Auth::user()->avatar }}" />
                                </a>

                                <div class="dropdown-menu shadow-sm border dropdown-menu-right mt-2" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('user.done', ['username' => Auth::user()->username]) }}" class="dropdown-item">
                                        <div class="font-weight-bold">
                                            {{ Auth::user()->firstname ? Auth::user()->firstname . ' ' . Auth::user()->lastname : '' }}
                                        </div>
                                        <div class="small">
                                            {{ "@" . Auth::user()->username }}
                                        </div>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-dark" href="{{ route('user.done', ['username' => Auth::user()->username]) }}">
                                        {{ Emoji::bustInSilhouette() }} Profile
                                    </a>
                                    <a class="dropdown-item text-dark" href="{{ route('user.pending', ['username' => Auth::user()->username]) }}">
                                        {{ Emoji::hourglassNotDone() }} Pending Tasks
                                    </a>
                                    <a class="dropdown-item text-dark" href="{{ route('user.settings.profile') }}">
                                        {{ Emoji::gear() }} Settings
                                    </a>
                                    <a class="dropdown-item text-dark" href="{{ route('patron.home') }}">
                                        {{ Emoji::handshake() }} Patron
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    @if (Auth::user()->isStaff)
                                    <a class="dropdown-item text-dark" id="admin-bar-click" role="button">
                                        @if (Auth::user()->staffShip)
                                        {{ Emoji::seeNoEvilMonkey() }} Hide Admin Bar
                                        @else
                                        {{ Emoji::eyes() }} Show Admin Bar
                                        @endif
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    @endif
                                    @if (Auth::user()->isPatron)
                                    <a class="dropdown-item text-dark" id="dark-mode" role="button">
                                        @if (Auth::user()->darkMode)
                                        {{ Emoji::sunWithFace() }} Light Mode
                                        @else
                                        {{ Emoji::newMoonFace() }} Dark Mode
                                        @endif
                                    </a>
                                    @endif
                                    @if (Auth::user()->isDeveloper)
                                    <a class="dropdown-item text-dark" href="https://gitlab.com/taskord/taskord" target="_blank">
                                        {{ Emoji::octopus() }} GitLab
                                    </a>
                                    @endif
                                    <a class="dropdown-item text-dark" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ Emoji::door() }} Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @if (session()->has('global'))
            <div class="alert alert-success alert-dismissible fade show rounded-0 mb-0">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <i class="fa fa-check mr-1"></i>
                {{ session('global') }}
            </div>
        @endif
        @auth
        @if (Auth::user()->isFlagged)
        <div class="alert alert-danger rounded-0" role="alert">
            <div class="font-weight-bold">
                <i class="fa fa-flag mr-1"></i>
                Your account has been flagged.
            </div>
            <div class="mt-1">
                Because of that, your profile will be hidden from the public. If you believe this is a mistake, <a href="#">contact support</a> to have your account status reviewed.
            </div>
        </div>
        @endif
        @if (!Auth::user()->hasVerifiedEmail())
        <div class="alert alert-warning rounded-0" role="alert">
            <div class="font-weight-bold">
                <i class="fa fa-envelope mr-1"></i>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="https://kit.fontawesome.com/4f46a7856f.js" crossorigin="anonymous"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178044316-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-178044316-1');
</script>
@auth
<script type="text/javascript">
    window.$crisp=[];
    window.$crisp.push(["set", "session:data", [[["user_id", "{{ Auth::id() }}"]]]]);
    window.$crisp.push(["set", "user:email", ["{{ Auth::user()->email }}"]]);
    window.$crisp.push(["set", "user:avatar", ["{{ Auth::user()->avatar }}"]]);
    window.$crisp.push(["set", "user:nickname", ["{{ Auth::user()->username }}"]]);
    window.CRISP_WEBSITE_ID="7770164a-8d1b-4b4f-9a7b-6c1f5a76d101";
    (function(){
        d=document;
        s=d.createElement("script");
        s.src="https://client.crisp.chat/l.js";
        s.async=1;
        d.getElementsByTagName("head")[0].appendChild(s);
    })();
</script>
@endauth
</html>
