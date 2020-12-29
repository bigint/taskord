<div wire:init="loadRecentlyJoined">
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Recently Joined
    </div>
    <div class="card mb-4">
        <div class="pt-2 pb-2">
        @if (!$readyToLoad)
        <div class="card-body text-center">
            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
        </div>
        @endif
        @foreach ($recently_joined as $user)
        <div class="d-flex align-items-center py-1 px-3">
            <a href="{{ route('user.done', ['username' => $user->username]) }}">
                <img
                    loading=lazy
                    class="rounded-circle avatar-40 mt-1 user-popover"
                    src="{{ Helper::getCDNImage($user->avatar, 160) }}"
                    data-id="{{ $user->id }}"
                    height="40" width="40"
                    alt="{{ $user->username }}'s avatar"
                />
            </a>
            <span class="ms-3">
                <a
                    href="{{ route('user.done', ['username' => $user->username]) }}"
                    class="align-text-top text-dark user-popover"
                    data-id="{{ $user->id }}"
                >
                    <span class="fw-bold">
                        @if ($user->firstname or $user->lastname)
                            {{ $user->firstname }}{{ ' '.$user->lastname }}
                        @else
                            {{ $user->username }}
                        @endif
                        @if ($user->isVerified)
                            <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
                        @endif
                    </span>
                    <div>
                        @if ($user->bio)
                        <span class="small">
                            {{ $user->bio }}
                        </span>
                        @else
                        <span class="small text-secondary">
                            Joined {{ Carbon::parse($user->created_at)->diffForHumans() }}
                        </span>
                        @endif
                    </div>
                </a>
            </span>
        </div>
        @endforeach
        </div>
        @if ($readyToLoad and $recently_joined_count > 5)
        <div class="card-footer">
            <span class="fw-bold">{{ $recently_joined_count - 5 }} more...</span>
        </div>
        @endif
    </div>
</div>
