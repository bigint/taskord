<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-md">
        <a class="navbar-brand" href="{{ url('/') }}">
            @auth
            @if (Auth::user()->isBeta)
            <img loading=lazy src="/images/beta.svg" height="35" alt="Taskord Beta">
            @else
            <img loading=lazy src="/images/logo.svg" height="35" alt="Taskord">
            @endif
            @endauth
            @guest
            <img loading=lazy src="/images/logo.svg" height="35" alt="Taskord">
            @endguest
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @livewire('search')
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-white fw-bold" href="{{ route('products.newest') }}">
                        Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white fw-bold" href="{{ route('questions.newest') }}">
                        Questions
                    </a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link text-white fw-bold" href="{{ route('tasks') }}">
                        Tasks
                        <x-beta background="dark" />
                    </a>
                </li>
                @endauth
                <li class="nav-item dropdown">
                    <a class="nav-link text-white fw-bold" href="#" data-bs-toggle="dropdown">
                        More
                    </a>
                    <ul class="dropdown-menu shadow-sm border">
                        <li><a class="dropdown-item text-dark" href="{{ route('deals') }}">🎁 Deals</a></li>
                        @auth
                        @if (Auth::user()->staffShip)
                        <li><a class="dropdown-item text-dark" href="{{ route('meetups.home') }}">👥 Meetups</a></li>
                        <li><a class="dropdown-item text-dark" href="#">🤔 Help</a></li>
                        <li><a class="dropdown-item text-dark" href="#">📊 Open</a></li>
                        @endif
                        <li><a class="dropdown-item text-dark" href="{{ route('user.settings.integrations') }}">⚓ Integration</a></li>
                        @endauth
                        <li><a class="dropdown-item text-dark" href="https://www.notion.so/Roadmap-89c75352cfe14d24b62644daa0f1cba0" target="_blank" rel="noreferrer">🚧 Roadmap</a></li>
                    </ul>
                </li>
                @if (Auth::check() and Auth::user()->isStaff and !Auth::user()->staffShip)
                <li class="nav-item">
                    <span class="nav-link text-secondary fw-bold">
                        {{ bcmul((microtime(true) - LARAVEL_START), '1000', 0) }}ms
                    </span>
                </li>
                @endif
            </ul>
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item me-3">
                        <a class="nav-link text-white fw-bold" href="{{ route('login') }}">Login</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-white btn btn-primary fw-bold" href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                @else
                    @livewire('notification.icon')
                    @if (Auth::user()->hasGoal)
                    <li class="nav-item me-2">
                        <div class="nav-link">
                            <a
                                href="{{ route('user.settings.profile') }}"
                                class="badge rounded-pill score text-white
                                    @if(Auth::user()->daily_goal_reached >= Auth::user()->daily_goal)
                                        bg-success
                                    @else
                                        bg-info
                                    @endif"
                            >
                                🎯 {{ Auth::user()->daily_goal_reached }}/{{ Auth::user()->daily_goal }}
                            </a>
                        </div>
                    </li>
                    @endif
                    <li class="nav-item me-2">
                        <a class="nav-link" href="{{ route('reputation') }}">
                            <span class="badge rounded-pill text-secondary score bg-warning">
                                🔥 {{ number_format(Auth::user()->getPoints()) }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" role="button" data-bs-toggle="dropdown" v-pre>
                            <img loading=lazy class="rounded-circle avatar-30 mt-1" src="{{ Helper::getCDNImage(Auth::user()->avatar, 80) }}" height="30" width="30" alt="{{ Auth::user()->username }}'s avatar" />
                        </a>

                        <div class="dropdown-menu shadow-sm border dropdown-menu-end mt-2">
                            <a href="{{ route('user.done', ['username' => Auth::user()->username]) }}" class="dropdown-item">
                                Signed in as
                                <div class="fw-bold">
                                    {{ Auth::user()->username }}
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <div class="px-2 text-dark">
                                @if (Auth::user()->status)
                                <a href="{{ route('user.done', ['username' => Auth::user()->username]) }}" class="border border-2 d-flex px-2 py-1 rounded text-dark text-start">
                                    {{ Auth::user()->status_emoji }} {{ Str::limit(Auth::user()->status, 10) }}
                                </a>
                                @else
                                <a href="{{ route('user.done', ['username' => Auth::user()->username]) }}" class="border border-2 d-flex px-2 py-1 rounded text-dark text-start">
                                    ✅ Set Staus
                                </a>
                                @endif
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-dark" href="{{ route('user.done', ['username' => Auth::user()->username]) }}">
                                👤 Profile
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('user.pending', ['username' => Auth::user()->username]) }}">
                                ⏳ Pending Tasks
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('user.settings.profile') }}">
                                ⚙ Settings
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('patron.home') }}" data-turbolinks="false">
                                🤝 Patron
                            </a>
                            <div class="dropdown-divider"></div>
                            @if (Auth::user()->isStaff)
                            <a class="dropdown-item text-dark" id="admin-bar-click" role="button">
                                @if (Auth::user()->staffShip)
                                🙈 Hide Admin Bar
                                @else
                                👀 Show Admin Bar
                                @endif
                            </a>
                            <div class="dropdown-divider"></div>
                            @endif
                            @if (Auth::user()->isPatron)
                            <a class="dropdown-item text-dark" id="dark-mode" role="button">
                                @if (Auth::user()->darkMode)
                                🌞 Light Mode
                                @else
                                🌚 Dark Mode
                                @endif
                            </a>
                            @endif
                            @if (Auth::user()->isDeveloper)
                            <a class="dropdown-item text-dark" href="https://gitlab.com/taskord/taskord" target="_blank" rel="noreferrer">
                                🦊 GitLab
                            </a>
                            @endif
                            <a class="dropdown-item text-dark" href="{{ route('logout') }}"
                                data-prefetch="false"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                🚪 Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-header text-dark-50 fw-bold">
                                v{{ config('app.version') }} • <a href="https://headwayapp.co/taskord-changelog" target="_blank" rel="noreferrer">Changelog</a>
                            </div>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
