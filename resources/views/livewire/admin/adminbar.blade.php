<div class="card p-1 rounded-0 d-flex border-bottom border-primary bg-primary text-white">
    <div class="pl-2 pr-2">
        <span class="float-left">
            <a class="text-white font-weight-bold" href="https://gitlab.com/taskord/taskord/-/tree/{{ $branchname }}" target="_blank">
                <i class="fa fa-code-branch mr-1"></i>
                {{ $branchname }}
            </a>
            <a class="text-white font-weight-bold ml-3" href="https://gitlab.com/taskord/taskord/-/releases/v{{ $version }}" target="_blank">
                <i class="fa fa-cube mr-1"></i>
                v{{ $version }}
            </a>
            <a class="text-white font-weight-bold ml-3" href="https://github.com/laravel/framework/releases/tag/v{{ App::VERSION() }}" target="_blank">
                <i class="fab fa-laravel mr-1"></i>
                Laravel v{{ App::VERSION() }}
            </a>
            <a class="text-white font-weight-bold ml-3" href="http://git.php.net/?p=php-src.git;a=shortlog;h=refs/heads/PHP-{{ phpversion() }}" target="_blank">
                <i class="fab fa-php mr-1"></i>
                PHP v{{ phpversion() }}
            </a>
        </span>
        <span class="float-right">
            <span role="button" class="dropdown dropleft">
                <span class="font-weight-bold mr-3" data-toggle="dropdown">
                    <i class="fa fa-chart-pie mr-1"></i>
                    Stats
                </span>
                <ul class="dropdown-menu shadow-sm border">
                    <li class="dropdown-item">
                        <span class="mr-3">
                            <i class="fa fa-check mr-1"></i>
                            <span class="font-weight-bold">{{ $tasks }}</span> Tasks
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="mr-3">
                            <i class="fa fa-users mr-1"></i>
                            <span class="font-weight-bold">{{ $users }}</span> Users
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="mr-3">
                            <i class="fa fa-box-open mr-1"></i>
                            <span class="font-weight-bold">{{ $products }}</span> Products
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="mr-3">
                            <i class="fa fa-question-circle mr-1"></i>
                            <span class="font-weight-bold">{{ $questions }}</span> Questions
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="mr-3">
                            <i class="fa fa-comments mr-1"></i>
                            <span class="font-weight-bold">{{ $answers }}</span> Answers
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="mr-3">
                            <i class="fa fa-comment mr-1"></i>
                            <span class="font-weight-bold">{{ $comments }}</span> Comments
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="mr-3">
                            <i class="fa fa-fire mr-1"></i>
                            <span class="font-weight-bold">{{ $reputations }}</span> Reputations
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="mr-3">
                            <i class="fa fa-bell mr-1"></i>
                            <span class="font-weight-bold">{{ $notifications }}</span> Notifications
                        </span>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li class="dropdown-item" wire:click="refreshStats">
                        <span class="mr-3">
                            <i class="fa fa-refresh mr-1"></i>
                            Refresh
                        </span>
                    </li>
                </ul>
            </span>
            <a class="font-weight-bold mr-3 text-white" href="/admin/horizon" target="_blank">
                <i class="fa fa-wrench mr-1"></i>
                {{ $jobs }}
                <span class="font-weight-normal">
                    jobs
                </span>
            </a>
            <span class="font-weight-bold mr-3">
                <i class="fa fa-clock mr-1"></i>
                {{ round(microtime(true) - LARAVEL_START, 2) * 1000 }}ms
                <span class="font-weight-normal">response total</span>
            </span>
            <span class="font-weight-bold mr-3">
                <a href="/graphiql" target="_blank">
                    <i class="fa fa-code text-white"></i>
                </a>
            </span>
            <span class="font-weight-bold">
                <a href="{{ route('admin.users') }}">
                    <i class="fa fa-rocket text-white"></i>
                </a>
            </span>
        </span>
    </div>
</div>
