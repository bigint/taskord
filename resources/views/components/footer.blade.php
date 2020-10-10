<div class="text-black-50 d-block lh-lg sticky-footer">
    <span class="pr-2 font-weight-bold">
        © Taskord
    </span>
    @auth
    @if (Auth::user()->staffShip)
    <a class="pr-2" href="{{ route('about') }}">
        About
    </a>
    @endif
    @endauth
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
    <a class="pr-2" href="{{ route('sponsors') }}">
        Sponsors
    </a>
    <a class="pr-2" href="https://forms.clickup.com/f/357rd-767/8PPJM0SN435CWUX4X2" target="_blank">
        Contact
    </a>
    @auth
    <a
        class="pr-2" href="#"
        data-feedback-fish
        data-feedback-fish-userid="{{ Auth::id() }}"
        data-feedback-fish-email="{{ Auth::user()->email }}"
    >
        Feedback
    </a>
    @else
    <a class="pr-2" href="#" data-feedback-fish>
        Feedback
    </a>
    @endauth
    @auth
    @if (Auth::user()->staffShip)
    <span class="pr-2 text-danger">
        Admin mode on
    </span>
    @endif
    @endauth
</div>
