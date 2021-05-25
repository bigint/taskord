<div class="card mb-2">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <x:shared.user-label-big :user="$milestone->user" />
            <span class="align-text-top small float-end ms-auto">
                <a class="text-secondary" href="{{ route('milestones.milestone', ['milestone' => $milestone]) }}">
                    {{ $milestone->created_at->diffForHumans() }}
                </a>
            </span>
        </div>
    </div>
    <div class="card-body pt-1">
        @if ($milestone->hidden)
            <span class="fst-italic text-secondary">Milestone was hidden by moderator</span>
        @else
            <a href="{{ route('milestones.milestone', ['milestone' => $milestone]) }}" class="h5 align-text-top fw-bold text-dark">
                @if ($type !== "milestones.milestone")
                    {{ Str::words($milestone->name, '10') }}
                @else
                    {{ $milestone->name }}
                @endif
            </a>
            <div class="my-2 body-font text-secondary">
                {!! markdown($milestone->description) !!}
            </div>
        @endif
        @if ($milestone->start_date or $milestone->end_date)
            @if ($milestone->start_date)
                <div class="mb-1">
                    <x-heroicon-o-calendar class="heroicon heroicon-18px" />
                    Started at <b class="text-dark">{{ carbon($milestone->start_date)->format('M d, Y') }}</b>
                </div>
            @endif
            @if ($milestone->end_date)
                <div>
                    @php
                        $past_due = $milestone->end_date < carbon();
                    @endphp
                    @if ($past_due)
                        <div class="text-danger">
                            <x-heroicon-o-exclamation class="heroicon heroicon-18px" />
                            Past due by <b>{{ carbon($milestone->end_date)->format('M d, Y') }}</b>
                        </div>
                    @else
                        <div class="text-dark">
                            <x-heroicon-o-calendar class="heroicon heroicon-18px" />
                            Due by <b>{{ carbon($milestone->end_date)->format('M d, Y') }}</b>
                        </div>
                    @endif
                </div>
            @endif
        @endif
        <livewire:milestone.progress :milestone="$milestone" :wire:key="$milestone->id" />
        <div class="mt-3">
            @auth
                @if (auth()->user()->hasLiked($milestone))
                    <button role="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praises">
                        <span wire:loading wire:target="togglePraise" class="spinner-border spinner-border-task" role="status"></span>
                        <x-heroicon-s-thumb-up wire:loading.remove wire:target="togglePraise" class="heroicon heroicon-15px me-0" />
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
                        <span wire:loading wire:target="togglePraise" class="spinner-border spinner-border-task" role="status"></span>
                        <x-heroicon-o-thumb-up wire:loading.remove wire:target="togglePraise" class="heroicon heroicon-15px me-0 text-secondary" />
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
                @if (auth()->user()->staff_mode or auth()->user()->id === $milestone->user->id)
                    @if ($type === "milestones.milestone")
                        <a href="{{ route('milestones.edit', ['milestone' => $milestone]) }}" class="btn btn-task btn-outline-info me-1">
                            <x-heroicon-o-pencil-alt class="heroicon heroicon-15px me-0 text-secondary" />
                            <span class="small text-dark fw-bold">
                                Edit
                            </span>
                        </a>
                    @endif
                    <button
                        role="button"
                        class="btn btn-task btn-outline-danger me-1"
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                        wire:click="deleteMilestone"
                        wire:loading.attr="disabled"
                        wire:offline.attr="disabled"
                        aria-label="Delete"
                    >
                        <x-heroicon-o-trash class="heroicon heroicon-15px me-0 text-secondary" />
                    </button>
                @endif
                @if (auth()->user()->staff_mode)
                    <button type="button" class="btn btn-task {{ $milestone->hidden ? 'btn-info' : 'btn-outline-info' }}" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $milestone->id }}" aria-label="Hide">
                        <x-heroicon-o-eye-off class="heroicon heroicon-15px me-0" />
                    </button>
                @endif
                @if (auth()->user()->staff_mode or auth()->user()->id === $milestone->user->id)
                    @if ($type === "milestones.milestone")
                        @if ($milestone->status)
                            <button type="button" class="btn btn-danger btn-task float-end" wire:click="toggleStatus" wire:loading.attr="disabled">
                                <x-heroicon-o-x class="heroicon heroicon-15px" />
                                Close Milestone
                            </button>
                        @else
                            <button type="button" class="btn btn-success btn-task text-white float-end" wire:click="toggleStatus" wire:loading.attr="disabled">
                                <x-heroicon-o-check class="heroicon heroicon-15px" />
                                Open Milestone
                            </button>
                        @endif
                    @else
                        @if ($milestone->status)
                            <div class="float-end text-success fw-bold">
                                OPENED
                            </div>
                        @else
                            <div class="float-end text-danger fw-bold">
                                CLOSED
                            </div>
                        @endif
                    @endif
                @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success me-1" aria-label="Praises">
                    <x-heroicon-o-thumb-up class="heroicon heroicon-15px me-0 text-secondary" />
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
