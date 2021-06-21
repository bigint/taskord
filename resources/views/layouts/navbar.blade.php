<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-md">
        <a class="navbar-brand" href="{{ url('/') }}">
            @if (feature('pride'))
                <img loading=lazy src="https://ik.imagekit.io/taskordimg/pride_vocaCTHn-.svg" height="35" alt="Happy Pride month" title="Happy Pride Month 💕">
            @else
                @auth
                    @if (auth()->user()->is_beta)
                        <img loading=lazy src="https://ik.imagekit.io/taskordimg/beta_J6zazpyIw.svg" height="35" alt="Taskord Beta" title="Taskord Beta">
                    @else
                        <img loading=lazy src="https://ik.imagekit.io/taskordimg/logo_FLhAmih_U.svg" height="35" alt="Taskord">
                    @endif
                @endauth
                @guest
                    <img loading=lazy src="https://ik.imagekit.io/taskordimg/logo_FLhAmih_U.svg" height="35" alt="Taskord">
                @endguest
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <livewire:search />
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
                         <x:labels.beta />
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-white fw-bold" href="#" data-bs-toggle="dropdown">
                        More
                    </a>
                    <ul class="dropdown-menu shadow-sm border">
                        <li>
                            <a class="dropdown-item text-dark" href="{{ route('milestones.opened') }}">
                                <x-heroicon-o-truck class="heroicon heroicon-18px text-secondary" />
                                Milestones
                                 <x:labels.beta />
                            </a>
                        </li>
                        @if (feature('meetups'))
                            <li>
                                <a class="dropdown-item text-dark" href="{{ route('meetups.upcoming') }}">
                                    <x-heroicon-o-user-group class="heroicon heroicon-18px text-secondary" />
                                    Meetups
                                     <x:labels.staff-ship />
                                </a>
                            </li>
                        @endif
                        @if (feature('help_menu'))
                            <li>
                                <a class="dropdown-item text-dark" href="#">
                                    <x-heroicon-o-support class="heroicon heroicon-18px text-secondary" />
                                    Help
                                     <x:labels.staff-ship />
                                </a>
                            </li>
                        @endif
                            @auth
                            <li>
                                <a class="dropdown-item text-dark" href="{{ route('user.settings.integrations') }}">
                                    <x-heroicon-o-link class="heroicon heroicon-18px text-secondary" />
                                    Integration
                                </a>
                            </li>
                        @endauth
                        <li>
                            <a class="dropdown-item text-dark" href="{{ route('deals') }}">
                                <x-heroicon-o-gift class="heroicon heroicon-18px text-secondary" />
                                Deals
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-dark" href="{{ route('open') }}">
                                <x-heroicon-o-chart-bar class="heroicon heroicon-18px text-secondary" />
                                Open
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-dark" href="https://www.notion.so/89c75352cfe14d24b62644daa0f1cba0" target="_blank" rel="noreferrer">
                                <x-heroicon-o-map class="heroicon heroicon-18px text-secondary" />
                                Roadmap
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item me-3">
                        <a class="nav-link text-white fw-bold" href="{{ route('login') }}">Login</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-white btn btn-primary rounded-pill fw-bold px-3" href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link text-white" href="#" id="navbarNewDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <x-heroicon-o-plus-circle class="heroicon-23px me-0" />
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarNewDropdown">
                            <li>
                                <a class="dropdown-item text-dark" href="#" data-bs-toggle="modal" data-bs-target="#newTaskModal">
                                    <x-heroicon-o-check-circle class="heroicon heroicon-18px text-secondary" />
                                    New Task
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-dark" href="{{ route('products.new') }}">
                                    <x-heroicon-o-cube class="heroicon heroicon-18px text-secondary" />
                                    New Product
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-dark" href="{{ route('questions.new') }}">
                                    <x-heroicon-o-question-mark-circle class="heroicon heroicon-18px text-secondary" />
                                    New Question
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-dark" href="{{ route('milestones.new') }}">
                                    <x-heroicon-o-truck class="heroicon heroicon-18px text-secondary" />
                                    New Milestone
                                </a>
                            </li>
                        </ul>
                    </li>
                    @include('layouts.modals.new-task')
                    <li class="nav-item me-2">
                        <a class="nav-link text-white" href="{{ route('notifications.unread') }}" aria-label="Notifications">
                            <x-heroicon-o-bell class="heroicon-23px me-0" />
                            @auth
                                @if (auth()->user()->unreadNotifications->count('id') !== 0)
                                    <span class="badge badge-pill bg-danger fw-bold small p-1 mb-2">{{ ' ' }}</span>
                                @endif
                            @endauth
                        </a>
                    </li>                    
                    @if (auth()->user()->has_goal)
                        <li class="nav-item me-2">
                            <div class="nav-link">
                                <a
                                    href="{{ route('user.settings.profile') }}{{ auth()->user()->vacation_mode ? '#vacation' : '#goal' }}"
                                >
                                        @if (auth()->user()->vacation_mode)
                                        <span class="badge rounded-pill score text-white bg-success" title="Vacation mode on">
                                            <x-heroicon-o-sun class="heroicon heroicon-15px me-0" />
                                        </span>
                                    @else
                                        <span
                                        class="badge rounded-pill score text-white
                                            @if(auth()->user()->daily_goal_reached >= auth()->user()->daily_goal)
                                                bg-success
                                            @else
                                                bg-info
                                            @endif">
                                            <x-heroicon-s-check-circle class="heroicon heroicon-15px" />
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
                                <x-heroicon-o-fire class="heroicon heroicon-15px text-danger" />
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
                                    <a href="{{ route('user.done', ['username' => auth()->user()->username]) }}" class="border border-2 d-flex px-2 py-1 rounded text-dark text-start">
                                        {{ auth()->user()->status_emoji }} {{ Str::limit(auth()->user()->status, 10) }}
                                    </a>
                                    @else
                                    <a href="{{ route('user.done', ['username' => auth()->user()->username]) }}#status-card" class="border border-2 d-flex px-2 py-1 rounded text-dark text-start">
                                        💭 Set Status
                                    </a>
                                @endif
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-dark" href="{{ route('user.done', ['username' => auth()->user()->username]) }}">
                                <x-heroicon-o-user class="heroicon heroicon-18px text-secondary" />
                                Profile
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('user.pending', ['username' => auth()->user()->username]) }}">
                                <x-heroicon-o-clock class="heroicon heroicon-18px text-secondary" />
                                Pending Tasks
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('user.settings.profile') }}">
                                <x-heroicon-o-cog class="heroicon heroicon-18px text-secondary" />
                                Settings
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('patron.home') }}">
                                <x-heroicon-o-star class="heroicon heroicon-18px text-secondary" />
                                Patron
                            </a>
                            <div class="dropdown-divider"></div>
                            @if (auth()->user()->is_staff)
                                <a class="dropdown-item text-dark" id="staff-bar-click" role="button">
                                    @can('staff.ops')
                                        <x-heroicon-o-eye-off class="heroicon heroicon-18px text-secondary" />
                                        Hide Staff Bar
                                    @else
                                        <x-heroicon-o-eye class="heroicon heroicon-18px text-secondary" />
                                        Show Staff Bar
                                    @endcan
                                </a>
                                <div class="dropdown-divider"></div>
                            @endif
                            <a class="dropdown-item text-dark" id="dark-mode" role="button">
                                @if (Cookie::get('color_mode') === 'dark')
                                    <x-heroicon-o-sun class="heroicon heroicon-18px text-secondary" />
                                    Light Mode
                                @else
                                    <x-heroicon-o-moon class="heroicon heroicon-18px text-secondary" />
                                    Dark Mode
                                @endif
                            </a>
                            @if (auth()->user()->is_contributor)
                                <a class="dropdown-item text-dark" href="https://gitlab.com/taskord/taskord" target="_blank" rel="noreferrer">
                                    <x-heroicon-o-code class="heroicon heroicon-18px text-secondary" />
                                    GitLab
                                </a>
                            @endif
                            <a class="dropdown-item text-dark cursor-pointer d-sm-none d-md-block" data-bs-toggle="modal" data-bs-target="#shortcutsModal">
                                <x-heroicon-o-view-grid class="heroicon heroicon-18px text-secondary" />
                                Shortcuts
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('logout') }}"
                                data-prefetch="false"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                <x-heroicon-o-logout class="heroicon heroicon-18px text-secondary" />
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-header text-secondary fw-bold">
                                <span>SHA</span> • <a id="site-sha" href="https://gitlab.com/taskord/taskord/-/commit/{{ config('app.sha') }}" target="_blank" rel="noreferrer">{{ config('app.sha') }}</a>
                            </div>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

@include('layouts.modals.shortcuts')
