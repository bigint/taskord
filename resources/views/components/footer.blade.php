<div class="text-black-50 d-block lh-lg sticky-footer">
    <span class="pe-2 fw-bold">
        © Taskord
    </span>
    @auth
    @if (Auth::user()->staffShip)
    <a class="pe-2" href="{{ route('about') }}">
        About
    </a>
    @endif
    @endauth
    <a class="pe-2" href="https://status.taskord.com" target="_blank">
        Status
    </a>
    <a class="pe-2" href="https://dev.to/taskord" target="_blank">
        Blog
    </a>
    <a class="pe-2" href="https://gitlab.com/taskord/taskord" target="_blank">
        GitLab
    </a>
    <a class="pe-2" href="{{ route('terms') }}">
        Terms
    </a>
    <a class="pe-2" href="{{ route('sponsors') }}">
        Sponsors
    </a>
    <a class="pe-2" href="{{ route('contact') }}">
        Contact
    </a>
    @auth
    @if (Auth::user()->staffShip)
    <span class="pe-2 text-danger">
        Admin mode on
    </span>
    @endif
    @endauth
</div>
