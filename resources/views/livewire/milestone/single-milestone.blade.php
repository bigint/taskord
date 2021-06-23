<div class="card mb-2">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <x:shared.user-label-big :user="$milestone->user" />
            <span class="align-text-top small float-end ms-auto">
                <a class="text-secondary" href="{{ route('milestones.milestone', ['milestone' => $milestone]) }}">
                    {{ carbon($milestone->created_at)->diffForHumans() }}
                </a>
            </span>
        </div>
    </div>
    <div class="card-body pt-1">
        @if ($milestone->hidden)
            <span class="fst-italic text-secondary">Milestone was hidden by moderator</span>
        @else
            <a href="{{ route('milestones.milestone', ['milestone' => $milestone]) }}"
                class="h5 align-text-top fw-bold text-dark">
                @if ($type !== 'milestones.milestone')
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
                <x:like-button :entity="$milestone" />
                @can('edit/delete', $milestone)
                    @if ($type === 'milestones.milestone')
                        <a href="{{ route('milestones.edit', ['milestone' => $milestone]) }}"
                            class="btn btn-action btn-outline-info me-1">
                            <x-heroicon-o-pencil-alt class="heroicon heroicon-15px me-0 text-secondary" />
                            <span class="small text-dark fw-bold">
                                Edit
                            </span>
                        </a>
                    @endif
                    <button role="button" class="btn btn-action btn-outline-danger me-1"
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteMilestone"
                        wire:loading.attr="disabled" aria-label="Delete">
                        <x-heroicon-o-trash class="heroicon heroicon-15px me-0 text-secondary" />
                    </button>
                @endcan
                @can('staff.ops')
                    <button type="button" class="btn btn-action {{ $milestone->hidden ? 'btn-info' : 'btn-outline-info' }}"
                        wire:click="hide" wire:loading.attr="disabled" wire:key="{{ $milestone->id }}" aria-label="Hide">
                        <x-heroicon-o-eye-off class="heroicon heroicon-15px me-0" />
                    </button>
                @endcan
                @if ($type === 'milestones.milestone')
                    @can('edit/delete', $milestone)
                        @if ($milestone->status)
                            <button type="button" class="btn btn-danger btn-action float-end" wire:click="toggleStatus"
                                wire:loading.attr="disabled">
                                <x-heroicon-o-x class="heroicon heroicon-15px" />
                                Close Milestone
                            </button>
                        @else
                            <button type="button" class="btn btn-success btn-action text-white float-end"
                                wire:click="toggleStatus" wire:loading.attr="disabled">
                                <x-heroicon-o-check class="heroicon heroicon-15px" />
                                Open Milestone
                            </button>
                        @endif
                    @endcan
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
            @endauth
            @guest
                <a href="/login" class="btn btn-action btn-outline-like me-1" aria-label="Likes">
                    <x-heroicon-o-heart class="heroicon heroicon-15px me-0" />
                    @if ($milestone->likerscount() !== 0)
                        <span class="small fw-bold">
                            {{ number_format($milestone->likerscount()) }}
                        </span>
                    @endif
                </a>
            @endguest
        </div>
    </div>
</div>
