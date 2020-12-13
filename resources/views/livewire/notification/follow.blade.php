<div>
    @if (Auth::user()->isFollowing($user))
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-danger">
        <i class="fa fa-user-minus mr-1"></i>
        Unfollow <span class="fw-bold">{{ '@'.$user->username }}</span>
    </button>
    @else
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-primary">
        <i class="fa fa-user-plus mr-1"></i>
        Follow back <span class="fw-bold">{{ '@'.$user->username }}</span>
    </button>
    @endif
    @if (session()->has('error'))
        <span class="ml-2 text-danger fw-bold">{{ session('error') }}</span>
    @endif
</div>
