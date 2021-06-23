<div class="card" wire:init="loadUsers">
    <div class="card-header h6 py-3 d-flex justify-content-between align-items-center">
        <div>
            <div class="h5">Users</div>
            <span class="fw-bold">{{ $readyToLoad ? $count : '···' }}</span>
            total users
        </div>
        <div class="d-flex align-items-center">
            <div class="spinner-border spinner-border-sm taskord-spinner text-secondary" wire:loading
                wire:target="query" role="status"></div>
            <input wire:model="query" type="text" class="form-control ms-2" placeholder="Search users...">
        </div>
    </div>
    <div class="px-3">
        @if (!$readyToLoad)
            <div class="card-body text-center mt-3">
                <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                <div class="h6">
                    Loading users...
                </div>
            </div>
        @else
            @foreach ($users as $user)
                <div class="card mt-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <x:shared.user-label-big :user="$user" />
                            <div title="{{ carbon($user->last_active)->format('M d, Y g:i A') }}">
                                @if ($user->last_active)
                                    @if (strtotime(carbon()) - strtotime($user->last_active) <= 5)
                                        <span class="fw-bold text-success">active</span>
                                    @else
                                        {{ carbon($user->last_active)->diffForHumans() }}
                                    @endif
                                @else
                                    <span class="small fw-bold text-secondary">Not Set</span>
                                @endif
                            </div>
                        </div>
                        @if ($user->bio)
                            <div class="pt-3 text-dark">
                                {{ $user->bio }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-lg-6">
                            <div class="col-lg">
                                <span class="fw-bold">{{ $user->followers()->count() }}</span> Followers
                            </div>
                            <div class="col-lg">
                                <span class="fw-bold">{{ $user->followings()->count() }}</span> Following
                            </div>
                            <div class="col-lg">
                                <span class="fw-bold">{{ number_format($user->getPoints()) }}</span> Reputations
                            </div>
                            <div class="col-lg">
                                <span class="fw-bold">{{ $user->tasks()->whereDone(true)->count('id') }}</span>
                                Completed tasks
                            </div>
                            <div class="col-lg">
                                <span class="fw-bold">{{ $user->tasks()->whereDone(false)->count('id') }}</span>
                                Pending tasks
                            </div>
                            <div class="col-lg">
                                <span class="fw-bold">{{ $user->comments()->count('id') }}</span> Comments
                            </div>
                            <div class="col-lg">
                                <span class="fw-bold">{{ $user->questions()->count('id') }}</span> Questions
                            </div>
                            <div class="col-lg">
                                <span class="fw-bold">{{ $user->answers()->count('id') }}</span> Answers
                            </div>
                            <div class="col-lg">
                                <span
                                    class="fw-bold">{{ $user->milestones()->whereStatus(true)->count('id') }}</span>
                                Open milestones
                            </div>
                            <div class="col-lg">
                                <span
                                    class="fw-bold">{{ $user->milestones()->whereStatus(false)->count('id') }}</span>
                                Closed milestones
                            </div>
                            <div class="col-lg">
                                <span class="fw-bold">{{ $user->ownedProducts('id')->count('id') }}</span> Products
                            </div>
                            <div class="col-lg">
                                <span class="fw-bold">{{ $user->products()->count() }}</span> Membership
                            </div>
                            <div class="col-lg">
                                <span class="fw-bold">{{ $user->notifications()->count('id') }}</span> Notifications
                            </div>
                            <div class="col-lg">
                                <span class="fw-bold">{{ $user->webhooks()->count('id') }}</span> Webhooks
                            </div>
                            <div class="col-lg">
                                <span
                                    class="fw-bold">{{ Spatie\Activitylog\Models\Activity::causedBy($user)->count('id') }}</span>
                                Logs
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-lg">
                                <div>
                                    <span>User ID:</span>
                                    <span class="text-secondary fw-bold">#{{ $user->id }}</span>
                                </div>
                                <div class="mt-1">
                                    <span>Email:</span>
                                    <span class="text-dark fw-bold">{{ $user->email }}</span>
                                    @if ($user->hasVerifiedEmail())
                                        <span class="badge bg-success">Verified</span>
                                    @else
                                        <span class="badge bg-danger">Un-verified</span>
                                    @endif
                                </div>
                                <div class="mt-1">
                                    <span>IP:</span>
                                    @if ($user->last_ip)
                                        <a class="fw-bold" href="https://ipinfo.io/{{ $user->last_ip }}"
                                            title="{{ $user->last_ip }}" target="_blank" rel="noreferrer">
                                            {{ Str::limit($user->last_ip, 15, '..') }}
                                        </a>
                                    @else
                                        <span class="small fw-bold text-secondary">Not logged</span>
                                    @endif
                                </div>
                                <div class="mt-1">
                                    <span>Created at:</span>
                                    <span class="fw-bold" title="{{ $user->created_at->format('M d, Y g:i A') }}">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </span>
                                    @if ($user->created_at->diffInDays(carbon('today')) < 7)
                                        🆕
                                    @endif
                                </div>
                                <div class="mt-1">
                                    <span>Updated at:</span>
                                    <span class="fw-bold" title="{{ $user->updated_at->format('M d, Y g:i A') }}">
                                        {{ $user->updated_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div>
                                    <span>Status:</span>
                                    @if ($user->is_suspended)
                                        <span class="badge bg-danger">Suspended</span>
                                    @endif
                                    @if ($user->spammy)
                                        <span class="badge bg-info">Flagged</span>
                                    @endif
                                    @if (!$user->is_suspended or !$user->spammy)
                                        <span class="badge bg-success">Good</span>
                                    @endif
                                </div>
                                <div class="mt-1">
                                    <span>Streaks:</span>
                                    <span class="badge bg-success">
                                        {{ $user->streaks }} {{ pluralize('Streak', $user->streaks) }}
                                    </span>
                                </div>
                                <div class="mt-1">
                                    <span>Plan:</span>
                                    @if (!$user->is_patron)
                                        <span class="badge bg-danger">Free user</span>
                                    @else
                                        @if ($user->patron)
                                            <span class="badge bg-success">Patron</span>
                                        @else
                                            <span class="badge bg-info">Gifted</span>
                                        @endif
                                    @endif
                                </div>
                                <div class="mt-1">
                                    <span>Via:</span>
                                    @if ($user->provider === 'google')
                                        <span>
                                            <img class="brand-icon"
                                                src="https://ik.imagekit.io/taskordimg/icons/google_LPvasOP5AT.svg"
                                                loading=lazy />
                                            <span>Google</span>
                                        </span>
                                    @elseif ($user->provider === 'twitter')
                                        <span class="badge bg-info">Twitter</span>
                                    @elseif ($user->provider === 'github')
                                        <span class="badge bg-dark">GitHub</span>
                                    @elseif ($user->provider === 'discord')
                                        <span class="badge bg-secondary">Discord</span>
                                    @else
                                        <span class="badge bg-primary">Web</span>
                                    @endif
                                </div>
                                <div class="mt-1">
                                    <span>Timezone:</span>
                                    <span class="fw-bold">
                                        {{ $user->timezone }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    {{ $readyToLoad ? $users->links() : '' }}
</div>
