<div wire:init="loadFollowing">
    @if (!$readyToLoad)
        <div class="card-body text-center mt-3 mb-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading followings...
            </div>
        </div>
    @endif
    @if ($readyToLoad and count($followings) === 0)
        <div class="card-body text-center mt-3 mb-3">
            <x-heroicon-o-users class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                {{ $user->username }} isn’t following anybody.
            </div>
        </div>
    @endif
    @foreach ($followings as $user)
        <div class="card mb-3">
            <div class="card-body d-flex align-items-center">
                <img loading=lazy class="rounded-circle avatar-40 mt-1"
                    src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="40" width="40"
                    alt="{{ $user->username }}'s avatar" />
                <span class="ms-3">
                    <a href="{{ route('user.done', ['username' => $user->username]) }}"
                        class="align-text-top text-dark">
                        <span class="fw-bold">
                            @if ($user->firstname or $user->lastname)
                                {{ $user->firstname }}{{ ' ' . $user->lastname }}
                            @else
                                {{ $user->username }}
                            @endif
                        </span>
                        <div class="mb-2">{{ $user->bio }}</div>
                    </a>
                    @auth
                        @if (auth()->user()->id !== $user->id && !$user->spammy)
                            @livewire('user.follow', [
                            'user' => $user
                            ], key($user->id))
                        @endif
                    @endauth
                </span>
            </div>
        </div>
    @endforeach
    {{ $readyToLoad ? $followings->links() : '' }}
</div>
