<div class="card" wire:init="loadUsers">
    <div class="card-header h6 py-3">
        <div class="h5">Deployments</div>
        Deployments happend on Taskord
    </div>
    <div class="px-3">
        @if (!$readyToLoad)
            <div class="card-body text-center mt-3">
                <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                <div class="h6">
                    Loading deployments...
                </div>
            </div>
        @else
            @if (count($deployments) === 0)
                <div class="card-body text-center mt-3 mb-3">
                    <x-heroicon-o-cloud class="heroicon heroicon-60px text-primary mb-2" />
                    <div class="h4">
                        No deployments found!
                    </div>
                </div>
            @endif
            <table class="table text-dark">
                <thead>
                    <tr>
                        <th scope="col">Status</th>
                        <th scope="col">Job</th>
                        <th scope="col">Deployed by</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Started at</th>
                        <th scope="col">Finished at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deployments as $deployment)
                        <tr>
                            <th>
                                @if ($deployment->status === 'success')
                                    <span class="badge bg-success p-2">
                                        Deployment Successful
                                    </span>
                                @elseif ($deployment->status === 'failed')
                                    <span class="badge bg-danger p-2">
                                        Deployment Failed
                                    </span>
                                @elseif ($deployment->status === 'pending')
                                    <span class="badge bg-secondary p-2">
                                        Deployment Pending
                                    </span>
                                @elseif ($deployment->status === 'running')
                                    <span class="badge bg-info p-2">
                                        In Progress
                                    </span>
                                @elseif ($deployment->status === 'preparing')
                                    <span class="badge bg-info p-2">
                                        Preparing to deploy
                                    </span>
                                @elseif ($deployment->status === 'canceled')
                                    <span class="badge bg-info p-2">
                                        Deployment Canceled
                                    </span>
                                @endif
                            </th>
                            <td>
                                <code class="fw-bold">
                                    #{{ $deployment->id }}
                                </code>
                                <a href="{{ $deployment->web_url }}" class="fw-bold ms-1" target="_blank">
                                    <x-heroicon-o-external-link class="heroicon" />
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="avatar-25 rounded-circle" src="{{ $deployment->user->avatar_url }}" />
                                    <span class="ms-2">{{ $deployment->user->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <x-heroicon-o-clock class="heroicon heroicon-15px me-1" />
                                    <span>{{ round($deployment->duration, 2) }} seconds</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary" title="{{ $deployment->started_at }}">
                                    {{ carbon($deployment->started_at)->diffForHumans() }}
                                </span>
                            </td>
                            <td>
                                <span class="text-secondary" title="{{ $deployment->started_at }}">
                                    {{ carbon($deployment->finished_at)->diffForHumans() }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
