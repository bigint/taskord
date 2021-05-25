<div class="text-secondary d-block lh-lg sticky-footer">
    <span class="pe-2 fw-bold">
        © Taskord
    </span>
    <a class="pe-2" href="{{ route('about') }}">
        About
    </a>
    <a class="pe-2" href="https://status.taskord.com" target="_blank" rel="noreferrer">
        Status
    </a>
    <a class="pe-2" href="https://dev.to/taskord" target="_blank" rel="noreferrer">
        Blog
    </a>
    <a class="pe-2" href="https://gitlab.com/yo/taskord" target="_blank" rel="noreferrer">
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
        @if (auth()->user()->is_staff)
            @if (auth()->user()->staff_mode)
                <span class="pe-2 text-danger">
                    <x-heroicon-o-shield-check class="heroicon me-0" />
                    Staff mode on
                </span>
            @else
                <span class="pe-2 text-success">
                    <x-heroicon-o-shield-exclamation class="heroicon me-0" />
                    Staff mode off
                </span>
            @endif
        @endif
    @endauth
</div>
