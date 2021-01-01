<div>
    @if (user()->isFollowing($user))
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-danger">
        <x-heroicon-o-user-remove class="heroicon" />
        Unfollow <span class="fw-bold">{{ '@'.$user->username }}</span>
    </button>
    @else
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-primary">
        <x-heroicon-o-user-add class="heroicon" />
        Follow back <span class="fw-bold">{{ '@'.$user->username }}</span>
    </button>
    @endif
</div>
