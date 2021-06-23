<div>
    @if (auth()->user()->isFollowing($user))
        <button wire:click="toggleFollow" wire:loading.attr="disabled"
            class="btn btn-sm btn-outline-danger rounded-pill">
            <x-heroicon-o-user-remove class="heroicon heroicon-15px" />
            Unfollow <span class="fw-bold">{{ '@' . $user->username }}</span>
        </button>
    @else
        <button wire:click="toggleFollow" wire:loading.attr="disabled"
            class="btn btn-sm btn-outline-primary rounded-pill">
            <x-heroicon-o-user-add class="heroicon heroicon-15px" />
            Follow back <span class="fw-bold">{{ '@' . $user->username }}</span>
        </button>
    @endif
</div>
