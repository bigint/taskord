<div class="d-flex lh-lg mt-5 text-secondary justify-content-center align-items-center">
    <div class="d-flex justify-content-evenly flex-grow-1">
        <span class="fw-bold">
            © {{ now()->year }} Taskord
        </span>
        <a href="{{ route('about') }}">
            About
        </a>
        <a href="https://status.taskord.com" target="_blank" rel="noreferrer">
            Status
        </a>
        <a href="https://dev.to/taskord" target="_blank" rel="noreferrer">
            Blog
        </a>
        <a href="/graphiql" target="_blank" rel="noreferrer">
            API
        </a>
        <a href="{{ route('contact') }}">
            Contact
        </a>
    </div>
    <div class="mx-3">
        <img loading=lazy src="/images/logo.svg" height="30" alt="Taskord Beta">
    </div>
    <div class="d-flex justify-content-evenly flex-grow-1">
        <a href="{{ route('terms') }}">
            Terms
        </a>
        <a href="{{ route('privacy') }}">
            Privacy
        </a>
        <a href="{{ route('security') }}">
            Security
        </a>
        <a href="{{ route('sponsors') }}">
            Sponsors
        </a>
        <a href="/graphiql" target="_blank" rel="noreferrer">
            API
        </a>
        <a href="https://gitlab.com/taskord/taskord" target="_blank" rel="noreferrer">
            GitLab
        </a>
        @auth
        @if (user()->staffShip)
        <span class="text-danger">
            Admin mode on
        </span>
        @endif
        @endauth
    </div>
</div>
