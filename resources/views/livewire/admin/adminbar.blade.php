<div class="card p-1 rounded-0 d-flex border-bottom border-primary bg-primary text-white">
    <div class="ps-2 pe-2">
        <span class="float-start">
            <span class="fw-bold">
                <x-heroicon-o-terminal class="heroicon" />
                <a class="text-white" href="https://gitlab.com/taskord/taskord/-/tree/{{ $branchname }}" target="_blank" rel="noreferrer">{{ $branchname }}</a>
                <span>➜</span>
                <a class="text-white" href="https://gitlab.com/taskord/taskord/-/commit/{{ $headHASH }}" target="_blank" rel="noreferrer">{{ Str::limit($headHASH, 8, '') }}</a>
            </span>
            <a class="text-white fw-bold ms-3"
                href="https://gitlab.com/taskord/taskord/-/releases/v{{ config('app.version') }}" target="_blank" rel="noreferrer">
                <x-heroicon-o-archive class="heroicon" />
                v{{ config('app.version') }}
            </a>
            <a class="text-white fw-bold ms-3"
                href="https://github.com/laravel/framework/releases/tag/v{{ App::VERSION() }}" target="_blank" rel="noreferrer">
                <x-heroicon-o-chip class="heroicon" />
                Laravel v{{ App::VERSION() }}
            </a>
            <a class="text-white fw-bold ms-3"
                href="http://git.php.net/?p=php-src.git;a=shortlog;h=refs/heads/PHP-{{ phpversion() }}" target="_blank" rel="noreferrer">
                <x-heroicon-o-code class="heroicon" />
                PHP v{{ phpversion() }}
            </a>
        </span>
        <span class="float-end">
            <span role="button" class="dropdown">
                <span class="fw-bold me-3" data-bs-toggle="dropdown">
                    <x-heroicon-o-chart-bar class="heroicon" />
                    Stats
                </span>
                <ul class="dropdown-menu shadow-sm border mt-2">
                    <li class="dropdown-item">
                        <x-heroicon-o-check class="heroicon text-secondary" />
                        <span class="fw-bold">{{ $tasks }}</span> Tasks
                    </li>
                    <li class="dropdown-item">
                        <x-heroicon-o-users class="heroicon text-secondary" />
                        <span class="fw-bold">{{ $users }}</span> Users
                    </li>
                    <li class="dropdown-item">
                        <x-heroicon-o-cube class="heroicon text-secondary" />
                        <span class="fw-bold">{{ $products }}</span> Products
                    </li>
                    <li class="dropdown-item">
                        <x-heroicon-o-question-mark-circle class="heroicon text-secondary" />
                        <span class="fw-bold">{{ $questions }}</span> Questions
                    </li>
                    <li class="dropdown-item">
                        <x-heroicon-o-chat-alt-2 class="heroicon text-secondary" />
                        <span class="fw-bold">{{ $answers }}</span> Answers
                    </li>
                    <li class="dropdown-item">
                        <x-heroicon-o-chat-alt class="heroicon text-secondary" />
                        <span class="fw-bold">{{ $comments }}</span> Comments
                    </li>
                    <li class="dropdown-item">
                        <x-heroicon-o-fire class="heroicon text-secondary" />
                        <span class="fw-bold">{{ $reputations }}</span> Reputations
                    </li>
                    <li class="dropdown-item">
                        <x-heroicon-o-thumb-up class="heroicon text-secondary" />
                        <span class="fw-bold">{{ $praises }}</span> Praises
                    </li>
                    <li class="dropdown-item">
                        <x-heroicon-o-bell class="heroicon text-secondary" />
                        <span class="fw-bold">{{ $notifications }}</span> Notifications
                    </li>
                    <li class="dropdown-item">
                        <x-heroicon-o-cloud-upload class="heroicon text-secondary" />
                        <span class="fw-bold">{{ $webhooks }}</span> Webhooks
                    </li>
                    <li class="dropdown-item">
                        <x-heroicon-o-switch-horizontal class="heroicon text-secondary" />
                        <span class="fw-bold">{{ $interactions }}</span> Interactions
                    </li>
                    <li class="dropdown-item">
                        <x-heroicon-o-collection class="heroicon text-secondary" />
                        <span class="fw-bold">{{ $logs }}</span> Logs
                    </li>
                    <div class="dropdown-divider"></div>
                    <li class="dropdown-item" wire:click="refreshStats">
                        <x-heroicon-o-refresh class="heroicon text-secondary" />
                        Refresh
                    </li>
                </ul>
            </span>
            <a class="fw-bold me-3 text-white" href="/admin/horizon" target="_blank" rel="noreferrer">
                <x-heroicon-o-collection class="heroicon" />
                {{ $jobs }}
                <span class="fw-normal">
                    jobs
                </span>
            </a>
            <span class="fw-bold me-3">
                <x-heroicon-o-clock class="heroicon" />
                {{ bcmul((microtime(true) - LARAVEL_START), '1000', 0) }}ms
                <span class="fw-normal">response total</span>
            </span>
            <span class="fw-bold me-3">
                <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#cleanModal" title="Clear Cache">
                    <x-heroicon-o-trash class="heroicon text-white" />
                </a>
            </span>
            <span class="fw-bold me-3">
                <a href="/graphiql" target="_blank" title="GraphiQL" rel="noreferrer">
                    <x-heroicon-o-cube-transparent class="heroicon text-white" />
                </a>
            </span>
            <span class="fw-bold">
                <a href="{{ route('admin.users') }}" title="Admin">
                    <x-heroicon-o-shield-check class="heroicon text-white" />
                </a>
            </span>
        </span>
    </div>
    <div wire:ignore.self class="modal" data-bs-backdrop="static" id="cleanModal" tabindex="-1" aria-labelledby="cleanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="cleanModalLabel">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="fw-bold mb-2 text-danger">This will do following actions</div>
                    <ul class="mb-0 text-dark">
                        <li>Clean <b>Application Cache</b></li>
                        <li>Clean Cached <b>Application Views</b></li>
                        <li>Clean Cached <b>Configuration</b></li>
                        <li>Purge <b>Cloudflare Cache</b></li>
                        <li>Cache the <b>Configuration</b></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" wire:loading.attr="disabled" wire:click="clean" data-bs-dismiss="modal">
                        Clean Cache
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
