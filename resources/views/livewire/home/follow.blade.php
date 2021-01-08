<div>
    @if (auth()->user()->isFollowing($user))
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-danger">
        <div wire:loading class="spinner-border spinner-border-sm me-1"></div>
        <x-heroicon-o-user-remove wire:loading.remove class="heroicon" />
        Unfollow
    </button>
    @else
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-primary">
        <div wire:loading class="spinner-border spinner-border-sm me-1"></div>
        <x-heroicon-o-user-add wire:loading.remove class="heroicon" />
        Follow
    </button>
    @endif
</div>
