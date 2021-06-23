<div wire:init="loadTopReputations">
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Top Reputations
    </div>
    <div class="card mb-4">
        @if (!$readyToLoad)
            <div class="card-body">
                <x:loaders.sidebar.reputation-skeleton count="10" />
            </div>
        @else
            <div class="pt-2 pb-2">
                @foreach ($reputations as $user)
                    <div class="py-2 px-3">
                        <span class="h6 text-secondary" style="vertical-align:sub">
                            @if ($loop->index === 0)
                                <span class="fw-bold" style="color:#38c172">
                                    #{{ $loop->index + 1 }}
                                </span>
                            @elseif ($loop->index === 1)
                                <span class="fw-bold" style="color:#6a63ec">
                                    #{{ $loop->index + 1 }}
                                </span>
                            @elseif ($loop->index === 2)
                                <span class="fw-bold" style="color:#fd5f60">
                                    #{{ $loop->index + 1 }}
                                </span>
                            @else
                                <span>
                                    #{{ $loop->index + 1 }}
                                </span>
                            @endif
                        </span>
                        <a href="{{ route('user.done', ['username' => $user->username]) }}" class="user-popover"
                            data-id="{{ $user->id }}">
                            <img loading=lazy class="rounded-circle avatar-30 mt-1 ms-2"
                                src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="30" width="30"
                                alt="{{ $user->username }}'s avatar" />
                        </a>
                        <a href="{{ route('user.done', ['username' => $user->username]) }}"
                            class="ms-2 me-2 align-text-top fw-bold text-dark user-popover"
                            data-id="{{ $user->id }}">
                            @if ($user->firstname or $user->lastname)
                                {{ $user->firstname }}{{ ' ' . $user->lastname }}
                            @else
                                {{ $user->username }}
                            @endif
                            @if ($user->status)
                                <span class="ms-1 small"
                                    title="{{ $user->status }}">{{ $user->status_emoji }}</span>
                            @endif
                            @if ($user->is_verified)
                                <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
                            @endif
                        </a>
                        <span class="badge rounded-pill score bg-warning text-reputation align-middle"
                            title="🔥 {{ number_format($user->getPoints()) }}">
                            <x-heroicon-o-fire class="heroicon heroicon-15px text-danger" />
                            {{ $user->getPoints(true) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
