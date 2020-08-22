<div>
    @if (Auth::user()->isFollowing($user))
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-danger mb-2">
        <i class="fa fa-user-minus mr-1"></i>
        Unfollow
        <span wire:target="followUser" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
    </button>
    @else
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-primary mb-2">
        <i class="fa fa-user-plus mr-1"></i>
        Follow
        <span wire:target="followUser" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
    </button>
    @endif
    @if (session()->has('error'))
        <span class="ml-2 text-danger font-weight-bold">{{ session('error') }}</span>
    @endif
</div>
