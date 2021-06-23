<div wire:init="loadTrendingMakers">
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Trending Makers
        <x:labels.beta />
    </div>
    <div class="card mb-4">
        <div class="pt-2 pb-2">
            @if (!$readyToLoad)
                <div class="card-body text-center">
                    <div class="spinner-border spinner-border-sm taskord-spinner text-secondary" role="status"></div>
                </div>
            @endif
            @foreach ($users as $user)
                <div class="d-flex align-items-center py-1 px-3">
                    <a href="{{ route('user.done', ['username' => $user->username]) }}">
                        <img loading=lazy class="rounded-circle avatar-40 mt-1 user-popover"
                            src="{{ Helper::getCDNImage($user->avatar, 160) }}" data-id="{{ $user->id }}"
                            height="40" width="40" alt="{{ $user->username }}'s avatar" />
                    </a>
                    <span class="ms-3">
                        <a href="{{ route('user.done', ['username' => $user->username]) }}"
                            class="align-text-top text-dark user-popover" data-id="{{ $user->id }}">
                            <span class="fw-bold">
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
                            </span>
                            <div>
                                @if ($user->bio)
                                    <span class="small">
                                        {{ $user->bio }}
                                    </span>
                                @else
                                    <span class="small text-secondary">
                                        {{ '@' . $user->username }}
                                    </span>
                                @endif
                            </div>
                        </a>
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>
