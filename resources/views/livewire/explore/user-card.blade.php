<div class="card" wire:init="loadUser">
    @if (!$readyToLoad)
        <x:loaders.user-card-skeleton />
    @else
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center py-3">
                <a href="{{ route('user.done', ['username' => $user->username]) }}">
                    <img loading=lazy class="rounded-circle avatar-100 mt-1 user-popover"
                        src="{{ Helper::getCDNImage($user->avatar) }}" data-id="{{ $user->id }}" height="40"
                        width="40" alt="{{ $user->username }}'s avatar" />
                </a>
                <div class="h4 mt-3 text-dark">
                    @if ($user->firstname or $user->lastname)
                        {{ $user->firstname }}{{ ' ' . $user->lastname }}
                    @endif
                </div>
                <div class="h5 text-secondary">
                    {{ $user->username }}
                </div>
                <div>
                    @if ($user->status)
                        <div class="d-inline-block border border-2 mt-2 px-2 py-1 rounded text-dark">
                            <span>{{ $user->status_emoji }}</span>
                            <span title="{{ $user->status }}">{{ Str::limit($user->status, '50') }}</span>
                        </div>
                    @endif
                </div>
            </li>
            <li class="list-group-item py-3 fw-bold text-primary">
                {{ $user->followings->count('id') }} following
                {{ pluralize('user', $user->followings->count('id')) }}
            </li>
            <li class="list-group-item py-3 fw-bold text-primary">
                {{ $user->tasks()->count('id') }}
                {{ pluralize('task', $user->tasks()->count('id')) }} created
            </li>
        </ul>
    @endif
</div>
