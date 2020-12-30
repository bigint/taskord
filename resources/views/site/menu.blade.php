<a href="{{ route('user.done', ['username' => Auth::user()->username]) }}" class="dropdown-item">
    Signed in as
    <div class="fw-bold" id="taskord-username">
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
    <x-heroicon-o-user class="heroicon-1x text-secondary" />
    Profile
</a>
<a class="dropdown-item text-dark" href="{{ route('user.pending', ['username' => Auth::user()->username]) }}">
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
@if (Auth::user()->isStaff)
<a class="dropdown-item text-dark" id="admin-bar-click" role="button">
    @if (Auth::user()->staffShip)
    <x-heroicon-o-eye-off class="heroicon-1x text-secondary" />
    Hide Admin Bar
    @else
    <x-heroicon-o-eye class="heroicon-1x text-secondary" />
    Show Admin Bar
    @endif
</a>
<div class="dropdown-divider"></div>
@endif
@if (Auth::user()->isPatron)
<a class="dropdown-item text-dark" id="dark-mode" role="button">
    @if (Auth::user()->darkMode)
    <x-heroicon-o-sun class="heroicon-1x text-secondary" />
    Light Mode
    @else
    <x-heroicon-o-moon class="heroicon-1x text-secondary" />
    Dark Mode
    @endif
</a>
@endif
@if (Auth::user()->isDeveloper)
<a class="dropdown-item text-dark" href="https://gitlab.com/taskord/taskord" target="_blank" rel="noreferrer">
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
