<div class="card" wire:init="loadStats" wire:poll>
    <div class="card-header h6 py-3">
        <div class="h5">Stats</div>
        Taskord Stats
    </div>
    <div class="card-body">
        @if (!$ready_to_load)
            <div class="card-body text-center mt-3">
                <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                <div class="h6">
                    Loading stats...
                </div>
            </div>
        @else
            <h5 class="mb-3">Models</h5>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header fw-bold d-flex align-items-center">
                            <x-heroicon-o-check class="heroicon me-1" />
                            <span>Tasks</span>
                        </div>
                        <div class="card-body">
                            <div class="h5 mb-0">
                                {{ $stats['tasks'] }}
                                <span class="fw-light">Tasks</span>
                            </div>
                            <hr />
                            <div>
                                <span>Done: <b>{{ $stats['tasks_done'] }}</b></span>
                                <span class="ms-1">Pending: <b>{{ $stats['tasks_pending'] }}</b></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header fw-bold d-flex align-items-center">
                            <x-heroicon-o-users class="heroicon me-1" />
                            <span>Users</span>
                        </div>
                        <div class="card-body">
                            <div class="h5 mb-0">
                                {{ $stats['users'] }}
                                <span class="fw-light">Users</span>
                            </div>
                            <hr />
                            <div>
                                <span>Active last 30 days: <b>{{ $stats['users_active'] }}</b></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header fw-bold d-flex align-items-center">
                            <x-heroicon-o-cube class="heroicon me-1" />
                            <span>Products</span>
                        </div>
                        <div class="card-body">
                            <div class="h5 mb-0">
                                {{ $stats['products'] }}
                                <span class="fw-light">Products</span>
                            </div>
                            <hr />
                            <div>
                                <span>Launched: <b>{{ $stats['products_launched'] }}</b></span>
                                <span class="ms-1">Unlaunched: <b>{{ $stats['products_unlaunched'] }}</b></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header fw-bold d-flex align-items-center">
                            <x-heroicon-o-question-mark-circle class="heroicon me-1" />
                            <span>Questions</span>
                        </div>
                        <div class="card-body">
                            <div class="h5 mb-0">
                                {{ $stats['questions'] }}
                                <span class="fw-light">Questions</span>
                            </div>
                            <hr />
                            <div>
                                <span>Answered: <b>{{ $stats['questions_answered'] }}</b></span>
                                <span class="ms-1">Unanswered: <b>{{ $stats['questions_unanswered'] }}</b></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header fw-bold d-flex align-items-center">
                            <x-heroicon-o-chat-alt-2 class="heroicon me-1" />
                            <span>Answers</span>
                        </div>
                        <div class="card-body">
                            <div class="h5 mb-0">
                                {{ $stats['answers'] }}
                                <span class="fw-light">Answers</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header fw-bold d-flex align-items-center">
                            <x-heroicon-o-chat-alt class="heroicon me-1" />
                            <span>Comments</span>
                        </div>
                        <div class="card-body">
                            <div class="h5 mb-0">
                                {{ $stats['comments'] }}
                                <span class="fw-light">Comments</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header fw-bold d-flex align-items-center">
                            <x-heroicon-o-truck class="heroicon me-1" />
                            <span>Milestones</span>
                        </div>
                        <div class="card-body">
                            <div class="h5 mb-0">
                                {{ $stats['milestones'] }}
                                <span class="fw-light">Milestones</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="mb-3 mt-4">Transactions</h5>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header fw-bold d-flex align-items-center">
                            <x-heroicon-o-fire class="heroicon me-1" />
                            <span>Reputations</span>
                        </div>
                        <div class="card-body">
                            <div class="h5 mb-0">
                                {{ $stats['reputations'] }}
                                <span class="fw-light">Reputations</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header fw-bold d-flex align-items-center">
                            <x-heroicon-o-thumb-up class="heroicon me-1" />
                            <span>Praises</span>
                        </div>
                        <div class="card-body">
                            <div class="h5 mb-0">
                                {{ $stats['praises'] }}
                                <span class="fw-light">Praises</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header fw-bold d-flex align-items-center">
                            <x-heroicon-o-bell class="heroicon me-1" />
                            <span>Notifications</span>
                        </div>
                        <div class="card-body">
                            <div class="h5 mb-0">
                                {{ $stats['notifications'] }}
                                <span class="fw-light">Notifications</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header fw-bold d-flex align-items-center">
                            <x-heroicon-o-cloud-upload class="heroicon me-1" />
                            <span>Webhooks</span>
                        </div>
                        <div class="card-body">
                            <div class="h5 mb-0">
                                {{ $stats['webhooks'] }}
                                <span class="fw-light">Webhooks</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header fw-bold d-flex align-items-center">
                            <x-heroicon-o-switch-horizontal class="heroicon me-1" />
                            <span>Interactions</span>
                        </div>
                        <div class="card-body">
                            <div class="h5 mb-0">
                                {{ $stats['interactions'] }}
                                <span class="fw-light">Interactions</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header fw-bold d-flex align-items-center">
                            <x-heroicon-o-collection class="heroicon me-1" />
                            <span>Logs</span>
                        </div>
                        <div class="card-body">
                            <div class="h5 mb-0">
                                {{ $stats['logs'] }}
                                <span class="fw-light">Logs</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
