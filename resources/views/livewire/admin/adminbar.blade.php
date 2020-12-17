<div class="card p-1 rounded-0 d-flex border-bottom border-primary bg-primary text-white">
    <div class="ps-2 pe-2">
        <span class="float-start">
            <a class="text-white fw-bold" href="https://gitlab.com/taskord/taskord/-/tree/{{ $branchname }}"
                target="_blank">
                <i class="fa fa-code-branch me-1"></i>
                {{ $branchname }}
            </a>
            <a class="text-white fw-bold ms-3"
                href="https://gitlab.com/taskord/taskord/-/releases/v{{ config('app.version') }}" target="_blank">
                <i class="fa fa-cube me-1"></i>
                v{{ config('app.version') }}
            </a>
            <a class="text-white fw-bold ms-3"
                href="https://github.com/laravel/framework/releases/tag/v{{ App::VERSION() }}" target="_blank">
                <i class="fab fa-laravel me-1"></i>
                Laravel v{{ App::VERSION() }}
            </a>
            <a class="text-white fw-bold ms-3"
                href="http://git.php.net/?p=php-src.git;a=shortlog;h=refs/heads/PHP-{{ phpversion() }}" target="_blank">
                <i class="fab fa-php me-1"></i>
                PHP v{{ phpversion() }}
            </a>
        </span>
        <span class="float-end">
            <span role="button" class="dropdown">
                <span class="fw-bold me-3" data-bs-toggle="dropdown">
                    <i class="fa fa-chart-pie me-1"></i>
                    Stats
                </span>
                <ul class="dropdown-menu shadow-sm border mt-2">
                    <li class="dropdown-item">
                        <span class="me-3">
                            <i class="fa fa-check me-1"></i>
                            <span class="fw-bold">{{ $tasks }}</span> Tasks
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="me-3">
                            <i class="fa fa-users me-1"></i>
                            <span class="fw-bold">{{ $users }}</span> Users
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="me-3">
                            <i class="fa fa-box-open me-1"></i>
                            <span class="fw-bold">{{ $products }}</span> Products
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="me-3">
                            <i class="fa fa-question-circle me-1"></i>
                            <span class="fw-bold">{{ $questions }}</span> Questions
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="me-3">
                            <i class="fa fa-comments me-1"></i>
                            <span class="fw-bold">{{ $answers }}</span> Answers
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="me-3">
                            <i class="fa fa-comment me-1"></i>
                            <span class="fw-bold">{{ $comments }}</span> Comments
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="me-3">
                            <i class="fa fa-fire me-1"></i>
                            <span class="fw-bold">{{ $reputations }}</span> Reputations
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="me-3">
                            <i class="fa fa-thumbs-up me-1"></i>
                            <span class="fw-bold">{{ $praises }}</span> Praises
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="me-3">
                            <i class="fa fa-bell me-1"></i>
                            <span class="fw-bold">{{ $notifications }}</span> Notifications
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="me-3">
                            <i class="fa fa-anchor me-1"></i>
                            <span class="fw-bold">{{ $webhooks }}</span> Webhooks
                        </span>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li class="dropdown-item" wire:click="refreshStats">
                        <span class="me-3">
                            <i class="fa fa-sync-alt me-1"></i>
                            Refresh
                        </span>
                    </li>
                </ul>
            </span>
            <a class="fw-bold me-3 text-white" href="/admin/horizon" target="_blank">
                <i class="fa fa-wrench me-1"></i>
                {{ $jobs }}
                <span class="fw-normal">
                    jobs
                </span>
            </a>
            <span class="fw-bold me-3">
                <i class="fa fa-clock me-1"></i>
                {{ round(microtime(true) - LARAVEL_START, 2) * 1000 }}ms
                <span class="fw-normal">response total</span>
            </span>
            <span class="fw-bold me-3">
                <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#cleanModal" title="Clear Cache">
                    <i class="fa fa-trash-alt text-white"></i>
                </a>
            </span>
            <span class="fw-bold me-3">
                <a href="/graphiql" target="_blank" title="GraphiQL">
                    <i class="fa fa-sitemap text-white"></i>
                </a>
            </span>
            <span class="fw-bold">
                <a href="{{ route('admin.users') }}" title="Admin">
                    <i class="fa fa-rocket text-white"></i>
                </a>
            </span>
        </span>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" id="cleanModal" tabindex="-1" aria-labelledby="cleanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cleanModalLabel">Are you sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="fw-bold mb-2 text-danger">This will do following actions</div>
                <ul class="mb-0">
                    <li>Clean <b>Application Cache</b></li>
                    <li>Clean <b>Response Cache</b></li>
                    <li>Clean Cached <b>Application Views</b></li>
                    <li>Clean Cached <b>Configuration</b></li>
                    <li>Purge <b>Cloudflare Cache</b></li>
                    <li>Cache the <b>Configuration</b></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('admin.clean') }}" class="btn btn-primary" data-turbolinks="false">Clean Cache</a>
            </div>
        </div>
    </div>
</div>