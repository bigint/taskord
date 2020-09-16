<div class="text-black-50 d-block lh-lg sticky-footer">
    <span class="pr-3 font-weight-bold">
        © Taskord
    </span>
    <a class="pr-2" href="{{ route('about') }}">
        About
    </a>
    <a class="pr-2" href="https://status.taskord.com" target="_blank">
        Status
    </a>
    <a class="pr-2" href="https://dev.to/taskord" target="_blank">
        Blog
    </a>
    <a class="pr-2" href="https://gitlab.com/taskord/taskord" target="_blank">
        GitLab
    </a>
    <a class="pr-2" href="{{ route('terms') }}">
        Terms
    </a>
    <a class="pr-2" href="{{ route('patron.home') }}">
        Patron
    </a>
    @auth
    @if (Auth::user()->staffShip)
    <span class="pr-2 text-danger">
        Admin mode on
    </span>
    @endif
    @endauth
</div>
