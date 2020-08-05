<div class="card p-1 rounded-0 d-flex border-bottom border-primary bg-primary text-white">
    <div class="pl-2 pr-2">
        <span class="float-left">
            <span class="font-weight-bold">
                <i class="fa fa-code-branch mr-1"></i>
                {{ $branchname }}
            </span>
            <span class="font-weight-bold ml-3">
                <i class="fa fa-cube mr-1"></i>
                v{{ $version }}
            </span>
            <span class="font-weight-bold ml-3">
                <i class="fab fa-laravel mr-1"></i>
                Laravel v{{ App::VERSION() }}
            </span>
            <a class="text-white" href="https://github.com/taskord/taskord" target="_blank">
                <span class="font-weight-bold ml-3">
                    <i class="fa text-white fa-github mr-1"></i>
                    GitHub
                </span>
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
                            <i class="fa fa-gift mr-1"></i>
                            <span class="font-weight-bold">{{ $praises }}</span> Praises
                        </span>
                    </li>
                    <li class="dropdown-item">
                        <span class="mr-3">
                            <i class="fa fa-fire mr-1"></i>
                            <span class="font-weight-bold">{{ $reputations }}</span> Reputations
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
            <span class="font-weight-bold">
                <i class="fa fa-clock mr-1"></i>
                {{ round(microtime(true) - LARAVEL_START, 2) * 1000 }}ms
                <span class="font-weight-normal">response total</span>
            </span>
        </span>
    </div>
</div>
