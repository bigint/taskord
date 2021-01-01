<div class="text-secondary d-block lh-lg sticky-footer">
    <span class="pe-2 fw-bold">
        © Taskord
    </span>
    @auth
    @if (user()->staffShip)
    <a class="pe-2" href="{{ route('about') }}">
        About
    </a>
    @endif
    @endauth
    <a class="pe-2" href="https://status.taskord.com" target="_blank" rel="noreferrer">
        Status
    </a>
    <a class="pe-2" href="https://dev.to/taskord" target="_blank" rel="noreferrer">
        Blog
    </a>
    <a class="pe-2" href="https://gitlab.com/taskord/taskord" target="_blank" rel="noreferrer">
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
    @if (user()->staffShip)
    <span class="pe-2 text-danger">
        Admin mode on
    </span>
    @endif
    @endauth
</div>
