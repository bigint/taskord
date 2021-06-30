<div class="card mb-2">
    <div class="card-body d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <a class="card d-inline-block" href="{{ route('badges.badge', ['slug' => $badge->slug]) }}"
                style="background: {{ $badge->color }}">
                <div class="p-4">
                    <img class="avatar-40" src="{{ $badge->icon }}" />
                </div>
            </a>
            <div class="ms-3">
                <a class="h5 text-dark"
                    href="{{ route('badges.badge', ['slug' => $badge->slug]) }}">{{ $badge->title }}</a>
                <div class="text-secondary small mb-2">Created by {{ '@' . $badge->user->username }}</div>
                <div class="text-secondary">
                    <span class="fw-bold">{{ $badge->subscribersCount() }}</span> people have this badge
                </div>
            </div>
        </div>
        <div>
            @auth
                @if ($badge->isSubscribedBy(auth()->user()))
                    <button wire:click="toggleAddBadge" wire:loading.attr="disabled"
                        class="btn btn-sm btn-outline-danger rounded-pill">
                        <x-heroicon-o-minus class="heroicon heroicon-15px" />
                        Remove Badge
                    </button>
                @else
                    <button wire:click="toggleAddBadge" wire:loading.attr="disabled"
                        class="btn btn-sm btn-outline-primary rounded-pill">
                        <x-heroicon-o-plus class="heroicon heroicon-15px" />
                        Add Badge
                    </button>
                @endif
                @can('staff.ops')
                    <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteBadge"
                        wire:loading.attr="disabled" class="ms-1 btn btn-sm btn-outline-danger rounded-pill">
                        <x-heroicon-o-trash class="heroicon heroicon-15px" />
                        Delete
                    </button>
                @endcan
            @else
                <a href="/login" class="btn btn-sm btn-outline-primary rounded-pill">
                    <x-heroicon-o-plus class="heroicon heroicon-15px" />
                    Add Badge
                </a>
            @endauth
        </div>
    </div>
</div>
