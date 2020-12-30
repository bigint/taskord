<div wire:init="loadFollowers">
    @if (!$readyToLoad)
    <div class="card-body text-center mt-3 mb-3">
        <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
        <div class="h6">
            Loading Followers...
        </div>
    </div>
    @endif
    @if ($readyToLoad and count($followers) === 0)
    <div class="card-body text-center mt-3 mb-3">
        <x-heroicon-o-users class="heroicon-4x text-primary mb-2" />
        <div class="h4">
            {{ $user->username }} doesn’t have any followers yet.
        </div>
    </div>
    @endif
    @foreach ($followers as $user)
    <div class="card mb-3">
        <div class="card-body d-flex align-items-center">
        <img loading=lazy class="rounded-circle avatar-40 mt-1" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="40" width="40" alt="{{ $user->username }}'s avatar" />
            <span class="ms-3">
                <a href="{{ route('user.done', ['username' => $user->username]) }}" class="align-text-top text-dark">
                    <span class="fw-bold">
                        @if ($user->firstname or $user->lastname)
                            {{ $user->firstname }}{{ ' '.$user->lastname }}
                        @else
                            {{ $user->username }}
                        @endif
                    </span>
                    <div class="mb-2">{{ $user->bio }}</div>
                </a>
                @auth
                @if (Auth::id() !== $user->id && !$user->isFlagged)
                    @livewire('user.follow', [
                        'user' => $user
                    ])
                @endif
                @endauth
            </span>
        </div>
    </div>
    @endforeach
</div>
