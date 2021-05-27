<div class="container my-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg d-flex justify-content-evenly flex-wrap">
            <span class="fw-bold me-2">
                © {{ now()->year }} Taskord
            </span>
            <a class="me-2" href="{{ route('about') }}">
                About
            </a>
            <a class="me-2" href="https://status.taskord.com" target="_blank" rel="noreferrer">
                Status
            </a>
            <a class="me-2" href="https://dev.to/taskord" target="_blank" rel="noreferrer">
                Blog
            </a>
            <a class="me-2" href="/graphiql" target="_blank" rel="noreferrer">
                API
            </a>
            <a href="{{ route('contact') }}">
                Contact
            </a>
        </div>
        <div class="col-1 d-flex justify-content-evenly my-2">
            <img loading=lazy src="https://ik.imagekit.io/taskordimg/logo_8lLu9EPFa.svg" height="30" alt="Taskord Beta">
        </div>
        <div class="col-lg d-flex justify-content-evenly flex-wrap">
            <a class="me-2" href="{{ route('terms') }}">
                Terms
            </a>
            <a class="me-2" href="{{ route('privacy') }}">
                Privacy
            </a>
            <a class="me-2" href="{{ route('open') }}">
                Open
            </a>
            <a class="me-2" href="{{ route('sponsors') }}">
                Sponsors
            </a>
            <a class="me-2" href="/graphiql" target="_blank" rel="noreferrer">
                API
            </a>
            <a href="https://gitlab.com/yo/taskord" target="_blank" rel="noreferrer">
                GitLab
            </a>
            @can('staff_mode')
                <span class="text-danger ms-2">
                    <x-heroicon-o-shield-check class="heroicon me-0" />
                    Staff mode on
                </span>
            @endcan
        </div>
    </div>
</div>
