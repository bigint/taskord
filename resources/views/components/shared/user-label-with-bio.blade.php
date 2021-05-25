<div class="d-flex align-items-center">
    <a
        href="{{ route('user.done', ['username' => $user->username]) }}"
        class="user-popover"
        data-id="{{ $user->id }}"
    >
        <img
            loading=lazy class="avatar-40 rounded-circle"
            src="{{ Helper::getCDNImage($user->avatar, 80) }}"
            height="40"
            width="40"
            alt="{{ $user->username }}'s avatar"
        />
    </a>
    <span class="ms-2">
        <a
            href="{{ route('user.done', ['username' => $user->username]) }}"
            class="fw-bold text-dark user-popover"
            data-id="{{ $user->id }}"
        >
            @if ($user->firstname or $user->lastname)
                {{ $user->firstname }}{{ ' '.$user->lastname }}
            @else
                {{ $user->username }}
            @endif
            @if ($user->status)
                <span class="ms-1 small" title="{{ $user->status }}">{{ $user->status_emoji }}</span>
            @endif
            @if ($user->is_verified)
                <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
            @endif
            @if ($user->is_patron)
                <a class="patron" href="{{ route('patron.home') }}" aria-label="Patron">
                    <x-heroicon-s-star class="heroicon text-gold" />
                </a>
            @endif
            @if ($user->is_staff)
                <span class="staff" title="Staff">
                    <x-heroicon-o-shield-check class="heroicon text-primary" />
                </span>
            @endif
            @if ($user->bio)
                <div class="fw-normal">
                    {{ $user->bio }}
                </div>
            @else
                <div class="small text-secondary fw-normal">
                    Joined {{ carbon($user->created_at)->diffForHumans() }}
                </div>
            @endif
        </a>
    </span>
</div>
