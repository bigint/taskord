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
                        <li><a class="dropdown-item text-dark" href="https://gitlab.com/taskord/taskord/-/milestones" target="_blank" rel="noreferrer">🚧 Roadmap</a></li>
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
                            >
                                <span
                                class="badge rounded-pill score text-white
                                    @if(Auth::user()->daily_goal_reached >= Auth::user()->daily_goal)
                                        bg-success
                                    @else
                                        bg-info
                                    @endif">
                                    <x-heroicon-s-check-circle class="heroicon-small" />
                                    {{ Auth::user()->daily_goal_reached }}/{{ Auth::user()->daily_goal }}
                                </span>
                            </a>
                        </div>
                    </li>
                    @endif
                    <li class="nav-item me-2">
                        <a class="nav-link" href="{{ route('reputation') }}">
                            <span class="badge rounded-pill text-reputation score bg-warning">
                                <x-heroicon-o-fire class="heroicon-small text-danger" />
                                {{ number_format(Auth::user()->getPoints()) }}
                            </span>
                        </a>
                    </li>
                    <li id="taskord-menu" class="nav-item dropdown">
                        <a href="#" role="button" data-bs-toggle="dropdown" v-pre>
                            <img loading=lazy class="rounded-circle avatar-30 mt-1" src="{{ Helper::getCDNImage(Auth::user()->avatar, 80) }}" height="30" width="30" alt="{{ Auth::user()->username }}'s avatar" />
                        </a>

                        <div class="dropdown-menu shadow-sm border dropdown-menu-end mt-2">
                            <div id="taskord-menu-content" class="text-center mt-4 mb-4">
                                <div class="spinner-border taskord-spinner text-secondary" role="status"></div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-header text-dark-50 fw-bold">
                                <span id="taskord-version">v{{ config('app.version') }}</span> • <a href="https://gitlab.com/taskord/taskord/-/blob/main/CHANGELOG.md" target="_blank" rel="noreferrer">Changelog</a>
                            </div>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="shortcutsModal" tabindex="-1" aria-labelledby="shortcutsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shortcutsModalLabel">Keyboard shortcuts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="shortcutsModalBody">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border taskord-spinner text-secondary" role="status"></div>
                </div>
            </div>
            <div class="d-flex justify-content-between modal-footer">
                <x-beta background="light" />
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
