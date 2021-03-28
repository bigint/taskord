<div class="card mb-2">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <a href="{{ route('user.done', ['username' => $milestone->user->username]) }}">
                <img loading=lazy class="avatar-40 rounded-circle" src="{{ Helper::getCDNImage($milestone->user->avatar, 80) }}" height="40" width="40" alt="{{ $milestone->user->username }}'s avatar" />
            </a>
            <span class="ms-2">
                <a
                    href="{{ route('user.done', ['username' => $milestone->user->username]) }}"
                    class="fw-bold text-dark user-popover"
                    data-id="{{ $milestone->user->id }}"
                >
                    @if ($milestone->user->firstname or $milestone->user->lastname)
                        {{ $milestone->user->firstname }}{{ ' '.$milestone->user->lastname }}
                    @else
                        {{ $milestone->user->username }}
                    @endif
                    @if ($milestone->user->status)
                    <span class="ms-1 small" title="{{ $milestone->user->status }}">{{ $milestone->user->status_emoji }}</span>
                    @endif
                    @if ($milestone->user->isVerified)
                        <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
                    @endif
                    @if ($milestone->user->isPatron)
                        <a class="patron" href="{{ route('patron.home') }}" aria-label="Patron">
                            <x-heroicon-s-star class="heroicon text-gold" />
                        </a>
                    @endif
                </a>
                <div class="small">{{ "@" . $milestone->user->username }}</div>
            </span>
            <span class="align-text-top small float-end ms-auto">
                <a class="text-secondary" href="{{ route('milestones.milestone', ['id' => $milestone->id]) }}">
                    {{ $milestone->created_at->diffForHumans() }}
                </a>
            </span>
        </div>
    </div>
    <div class="card-body pt-1">
        @if ($milestone->hidden)
        <span class="task-font fst-italic text-secondary">Milestone was hidden by moderator</span>
        @else
        @if ($milestone->start_date or $milestone->end_date)
        <div class="mb-3">
            @if ($milestone->start_date)
            <div class="mb-1">
                <x-heroicon-o-calendar class="heroicon-1x" />
                Started at <b>{{ carbon($milestone->start_date)->format('M d, Y') }}</b>
            </div>
            @endif
            @if ($milestone->end_date)
            <div>
                <x-heroicon-o-calendar class="heroicon-1x" />
                Due by <b>{{ carbon($milestone->end_date)->format('M d, Y') }}</b>
            </div>
            @endif
        </div>
        @endif
        <a href="{{ route('milestones.milestone', ['id' => $milestone->id]) }}" class="h5 align-text-top fw-bold text-dark">
            @if ($type !== "milestones.milestone")
                {{ Str::words($milestone->name, '10') }}
            @else
                {{ $milestone->name }}
            @endif
        </a>
        <div class="mt-2 body-font">
            {!! Markdown::parse($milestone->description) !!}
        </div>
        @endif
        <div class="mt-3">
            @auth
            @if (auth()->user()->hasLiked($milestone))
                <button role="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praises">
                    <x-heroicon-s-thumb-up class="heroicon-small me-0" />
                    <span class="small text-white fw-bold">
                        {{ number_format($milestone->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($milestone->likers->take(5) as $user)
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                    @endforeach
                    </span>
                </button>
            @else
                <button role="button" class="btn btn-task btn-outline-success me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praises">
                    <x-heroicon-o-thumb-up class="heroicon-small me-0 text-secondary" />
                    @if ($milestone->likerscount() !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($milestone->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($milestone->likers->take(5) as $user)
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                    @endforeach
                    </span>
                    @endif
                </button>
            @endif
            @if (auth()->user()->staffShip or auth()->user()->id === $milestone->user->id)
            @if ($type === "milestones.milestone")
            <button role="button" class="btn btn-task btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#editMilestoneModal">
                <x-heroicon-o-pencil-alt class="heroicon-small me-0 text-secondary" />
                <span class="small text-dark fw-bold">
                    Edit
                </span>
            </button>
            @livewire('milestone.edit-milestone', [
                'milestone' => $milestone
            ])
            @endif
            @if ($confirming === $milestone->id)
            <button role="button" class="btn btn-task btn-danger me-1" wire:click="deleteMilestone" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Confirm Delete">
                Are you sure?
            </button>
            @else
            <button role="button" class="btn btn-task btn-outline-danger me-1" wire:click="confirmDelete" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Delete">
                <x-heroicon-o-trash class="heroicon-small me-0 text-secondary" />
            </button>
            @endif
            @endif
            @if (auth()->user()->staffShip)
            <button type="button" class="btn btn-task {{ $milestone->hidden ? 'btn-info' : 'btn-outline-info' }}" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $milestone->id }}" title="Flag to admins" aria-label="Hide">
                <x-heroicon-o-eye-off class="heroicon-small me-0" />
            </button>
            @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success me-1" aria-label="Praises">
                    <x-heroicon-o-thumb-up class="heroicon-small me-0 text-secondary" />
                    @if ($milestone->likerscount() !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($milestone->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($milestone->likers->take(5) as $user)
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                    @endforeach
                    </span>
                    @endif
                </a>
            @endguest
        </div>
    </div>
</div>
