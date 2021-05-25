<div>
    @auth
        @if (auth()->user()->id !== $user->id && !$user->spammy)
            @if (auth()->user()->isFollowing($user))
                <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-danger mb-2">
                    <div wire:loading class="spinner-border spinner-border-sm me-1"></div>
                    <x-heroicon-o-user-remove wire:loading.remove class="heroicon" />
                    Unfollow
                </button>
            @else
                <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-primary mb-2">
                    <div wire:loading class="spinner-border spinner-border-sm me-1"></div>
                    <x-heroicon-o-user-add wire:loading.remove class="heroicon" />
                    Follow
                </button>
            @endif
        @endif
    @endauth
    <div class="small">
        <a class="text-dark" href="{{ route('user.following', ['username' => $user->username]) }}">
            <span class="fw-bold">{{ $user->followings->count('id') }}</span>
            {{ pluralize('Following', $user->followings->count('id')) }}
        </a>
        <a class="text-dark" href="{{ route('user.followers', ['username' => $user->username]) }}">
            <span class="fw-bold ms-2">{{ number_format($user->followers->count()) }}</span>
            {{ pluralize('Follower', $user->followers->count('id')) }}
        </a>
    </div>
</div>
