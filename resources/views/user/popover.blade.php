@if ($user->status)
    <div class="px-3 py-2 border-bottom tippy-status text-dark">
        {{ $user->status_emoji }} {{ $user->status }}
    </div>
@endif
<div class="d-flex p-3">
    <div>
        <a href="{{ route('user.done', ['username' => $user->username]) }}">
            <img loading=lazy class="avatar-50 rounded-circle" src="{{ Helper::getCDNImage($user->avatar, 80) }}"
                height="50" width="50" alt="{{ $user->username }}'s avatar" />
        </a>
        @if ($user->is_patron)
            <div class="border border-primary mt-2 ps-1 pe-1 rounded-pill small text-center text-primary">Patron</div>
        @endif
    </div>
    <div class="ms-3">
        <a class="fw-bold text-dark" href="{{ route('user.done', ['username' => $user->username]) }}">
            @if ($user->firstname or $user->lastname)
                {{ $user->firstname }}{{ ' ' . $user->lastname }}
            @else
                {{ $user->username }}
            @endif
            @if ($user->is_verified)
                <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
            @endif
        </a>
        <div>
            <a class="small text-dark"
                href="{{ route('user.done', ['username' => $user->username]) }}">{{ '@' . $user->username }}</a>
        </div>
        @if ($user->bio)
            <div class="mt-2 text-dark">{{ $user->bio }}</div>
        @endif
        @if ($user->location)
            <div class="mt-2 text-dark">
                <x-heroicon-o-map class="heroicon text-secondary" />
                {{ $user->location }}
            </div>
        @endif
        @if ($user->company)
            <div class="mt-2 text-dark">
                <x-heroicon-o-briefcase class="heroicon text-secondary" />
                {{ $user->company }}
            </div>
        @endif
    </div>
</div>
