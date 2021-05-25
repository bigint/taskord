<div class="card mb-4">
    <div class="card-header d-flex align-items-center h6 py-3">
        <x:shared.user-label-big :user="$update->user" />
    </div>
    <div class="card-body">
        <div>{!! markdown($update->body) !!}</div>
        <div class="mt-2">
            @auth
                @if (!$update->user->is_private)
                    @if (auth()->user()->hasLiked($update))
                        <span>
                            <button type="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $update->id }}" aria-label="Praise">
                                <span wire:loading wire:target="togglePraise" class="spinner-border spinner-border-task" role="status"></span>
                                <x-heroicon-s-thumb-up wire:loading.remove wire:target="togglePraise" class="heroicon heroicon-15px me-0" />
                                <span class="small text-white fw-bold">
                                    {{ number_format($update->likerscount()) }}
                                </span>
                                <span class="avatar-stack ms-1">
                                    @foreach($update->likers->take(5) as $user)
                                        <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                                    @endforeach
                                </span>
                            </button>
                        </span>
                    @else
                        <span>
                            <button type="button" class="btn btn-task btn-outline-success me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $update->id }}" aria-label="Praises">
                                <span wire:loading wire:target="togglePraise" class="spinner-border spinner-border-task" role="status"></span>
                                <x-heroicon-o-thumb-up wire:loading.remove wire:target="togglePraise" class="heroicon heroicon-15px me-0" />
                                @if ($update->likerscount() !== 0)
                                    <span class="small text-dark fw-bold">
                                        {{ number_format($update->likerscount()) }}
                                    </span>
                                    <span class="avatar-stack ms-1">
                                        @foreach($update->likers->take(5) as $user)
                                            <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                                        @endforeach
                                    </span>
                                @endif
                            </button>
                        </span>
                    @endif
                @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success me-1" aria-label="Praises">
                    <x-heroicon-o-thumb-up class="heroicon heroicon-15px me-0" />
                    @if ($update->likerscount() !== 0)
                        <span class="small text-dark fw-bold">
                            {{ number_format($update->likerscount()) }}
                        </span>
                        <span class="avatar-stack ms-1">
                            @foreach($update->likers->take(5) as $user)
                                <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                            @endforeach
                        </span>
                    @endif
                </a>
            @endguest
            @auth
                @if (auth()->user()->staff_mode or auth()->user()->id === $update->user->id)
                    <button
                        type="button"
                        class="btn btn-task btn-outline-danger"
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                        wire:click="deleteUpdate"
                        wire:loading.attr="disabled"
                        wire:offline.attr="disabled"
                        aria-label="Delete"
                    >
                        <x-heroicon-o-trash class="heroicon heroicon-15px me-0" />
                    </button>
                @endif
            @endauth
        </div>
    </div>
</div>
