<div wire:init="loadSuggestions">
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Who to follow <x-beta background="light" />
    </div>
    <div class="card mb-4">
        <div class="pt-2 pb-2">
            @if (!$readyToLoad)
            <div class="card-body text-center">
                <div class="spinner-border spinner-border-sm taskord-spinner text-secondary" role="status"></div>
            </div>
            @endif
            <ul class="list-group list-group-flush">
                @foreach ($users as $user)
                <li class="list-group-item d-flex align-items-center justify-content-between" wire:key="{{ $user->id }}">
                    <span class="d-flex align-items-center">
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
                                    {{ '@'.$user->username }}
                                </div>
                            </a>
                        </span>
                    </span>
                    <span>
                        @livewire('home.follow', [
                            'user' => $user
                        ], key($user->id))
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
