<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-md">
        <a class="navbar-brand" href="{{ url('/') }}">
            @auth
            @if (auth()->user()->isBeta)
            <img loading=lazy src="https://ik.imagekit.io/taskordimg/beta_J6zazpyIw.svg" height="35" alt="Taskord Beta" title="Taskord Beta">
            @else
            <img loading=lazy src="https://ik.imagekit.io/taskordimg/logo_8lLu9EPFa.svg" height="35" alt="Taskord">
            @endif
            @endauth
            @guest
            <img loading=lazy src="https://ik.imagekit.io/taskordimg/logo_8lLu9EPFa.svg" height="35" alt="Taskord">
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
                    </a>
                </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link text-white fw-bold" href="{{ route('explore.explore') }}">
                        Explore
                        <x-beta />
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-white fw-bold" href="#" data-bs-toggle="dropdown">
                        More
                    </a>
                    <ul class="dropdown-menu shadow-sm border">
                        <li>
                            <a class="dropdown-item text-dark" href="{{ route('milestones.opened') }}">
                                <x-heroicon-o-truck class="heroicon-1x text-secondary" />
                                Milestones
                                <x-beta />
                            </a>
                        </li>
                        @auth
                        @if (feature('meetups'))
                        <li>
                            <a class="dropdown-item text-dark" href="{{ route('meetups.home') }}">
                                <x-heroicon-o-user-group class="heroicon-1x text-secondary" />
                                Meetups
                                <x-staffship />
                            </a>
                        </li>
                        @endif
                        @if (feature('help_menu'))
                        <li>
                            <a class="dropdown-item text-dark" href="#">
                                <x-heroicon-o-support class="heroicon-1x text-secondary" />
                                Help
                                <x-staffship />
                            </a>
                        </li>
                        @endif
                        <li>
                            <a class="dropdown-item text-dark" href="{{ route('user.settings.integrations') }}">
                                <x-heroicon-o-link class="heroicon-1x text-secondary" />
                                Integration
                            </a>
                        </li>
                        @endauth
                        <li>
                            <a class="dropdown-item text-dark" href="{{ route('deals') }}">
                                <x-heroicon-o-gift class="heroicon-1x text-secondary" />
                                Deals
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-dark" href="{{ route('open') }}">
                                <x-heroicon-o-chart-bar class="heroicon-1x text-secondary" />
                                Open
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-dark" href="https://gitlab.com/yo/taskord/-/milestones" target="_blank" rel="noreferrer">
                                <x-heroicon-o-map class="heroicon-1x text-secondary" />
                                Roadmap
                            </a>
                        </li>
                    </ul>
                </li>
                @if (Auth::check() and auth()->user()->isStaff and !auth()->user()->staffShip)
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
                    <a class="nav-link text-white" href="{{ route('notifications.unread') }}" data-bs-toggle="modal" data-bs-target="#newTaskModal">
                        <x-heroicon-o-plus-circle class="heroicon-notification me-0" />
                    </a>
                    @include('layouts.modals.new-task')
                    @livewire('notification.icon')
                    @if (auth()->user()->hasGoal)
                    <li class="nav-item me-2">
                        <div class="nav-link">
                            <a
                                href="{{ route('user.settings.profile') }}{{ auth()->user()->vacation_mode ? '#vacation' : '#goal' }}"
                            >
                                @if (auth()->user()->vacation_mode)
                                <span class="badge rounded-pill score text-white bg-success" title="Vacation mode on">
                                    <x-heroicon-o-sun class="heroicon-small me-0" />
                                </span>
                                @else
                                <span
                                class="badge rounded-pill score text-white
                                    @if(auth()->user()->daily_goal_reached >= auth()->user()->daily_goal)
                                        bg-success
                                    @else
                                        bg-info
                                    @endif">
                                    <x-heroicon-s-check-circle class="heroicon-small" />
                                    {{ auth()->user()->daily_goal_reached }}/{{ auth()->user()->daily_goal }}
                                </span>
                                @endif
                            </a>
                        </div>
                    </li>
                    @endif
                    <li class="nav-item me-2">
                        <a class="nav-link" href="{{ route('reputation') }}">
                            <span class="badge rounded-pill text-reputation score bg-warning">
                                <x-heroicon-o-fire class="heroicon-small text-danger" />
                                {{ number_format(auth()->user()->getPoints()) }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" role="button" data-bs-toggle="dropdown" v-pre>
                            <img loading=lazy class="rounded-circle avatar-30 mt-1" src="{{ Helper::getCDNImage(auth()->user()->avatar, 80) }}" height="30" width="30" alt="{{ auth()->user()->username }}'s avatar" />
                        </a>

                        <div class="dropdown-menu shadow-sm border dropdown-menu-end mt-2">
                            <a href="{{ route('user.done', ['username' => auth()->user()->username]) }}" class="dropdown-item">
                                Signed in as
                                <div class="fw-bold" id="taskord-username">
                                    {{ auth()->user()->username }}
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <div class="px-2 text-dark">
                                @if (auth()->user()->status)
                                <a href="{{ route('user.done', ['username' => auth()->user()->username]) }}" class="border border-dark border-1 d-flex px-2 py-1 rounded text-dark text-start">
                                    {{ auth()->user()->status_emoji }} {{ Str::limit(auth()->user()->status, 10) }}
                                </a>
                                @else
                                <a href="{{ route('user.done', ['username' => auth()->user()->username]) }}" class="border border-2 d-flex px-2 py-1 rounded text-dark text-start">
                                    💭 Set Status
                                </a>
                                @endif
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-dark" href="{{ route('user.done', ['username' => auth()->user()->username]) }}">
                                <x-heroicon-o-user class="heroicon-1x text-secondary" />
                                Profile
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('user.pending', ['username' => auth()->user()->username]) }}">
                                <x-heroicon-o-clock class="heroicon-1x text-secondary" />
                                Pending Tasks
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('user.settings.profile') }}">
                                <x-heroicon-o-cog class="heroicon-1x text-secondary" />
                                Settings
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('patron.home') }}">
                                <x-heroicon-o-star class="heroicon-1x text-secondary" />
                                Patron
                            </a>
                            <div class="dropdown-divider"></div>
                            @if (auth()->user()->isStaff)
                            <a class="dropdown-item text-dark" id="admin-bar-click" role="button">
                                @if (auth()->user()->staffShip)
                                <x-heroicon-o-eye-off class="heroicon-1x text-secondary" />
                                Hide Admin Bar
                                @else
                                <x-heroicon-o-eye class="heroicon-1x text-secondary" />
                                Show Admin Bar
                                @endif
                            </a>
                            <div class="dropdown-divider"></div>
                            @endif
                            @if (auth()->user()->isPatron)
                            <a class="dropdown-item text-dark" id="dark-mode" role="button">
                                @if (auth()->user()->darkMode)
                                <x-heroicon-o-sun class="heroicon-1x text-secondary" />
                                Light Mode
                                @else
                                <x-heroicon-o-moon class="heroicon-1x text-secondary" />
                                Dark Mode
                                @endif
                            </a>
                            @endif
                            @if (auth()->user()->isDeveloper)
                            <a class="dropdown-item text-dark" href="https://gitlab.com/yo/taskord" target="_blank" rel="noreferrer">
                                <x-heroicon-o-code class="heroicon-1x text-secondary" />
                                GitLab
                            </a>
                            @endif
                            <a class="dropdown-item text-dark cursor-pointer d-sm-none d-md-block" data-bs-toggle="modal" data-bs-target="#shortcutsModal">
                                <x-heroicon-o-view-grid class="heroicon-1x text-secondary" />
                                Shortcuts
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('logout') }}"
                                data-prefetch="false"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                <x-heroicon-o-logout class="heroicon-1x text-secondary" />
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-header text-dark-50 fw-bold">
                                <span id="taskord-version">v{{ config('app.version') }}</span> • <a href="https://gitlab.com/yo/taskord/-/blob/main/CHANGELOG.md" target="_blank" rel="noreferrer">Changelog</a>
                            </div>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

@include('layouts.modals.shortcuts')
