<div id="reply_{{ $reply->id }}">
    <div class="align-items-center d-flex">
        <x:shared.user-label-small :user="$reply->user" />
        <span class="align-text-top small float-end ms-auto text-secondary">
            {{ carbon($reply->created_at)->diffForHumans() }}
        </span>
    </div>
    <div class="border-2 border-start ps-3 reply-line pt-2 pb-3">
        @if ($reply->hidden)
            <span class="body-font fst-italic text-secondary">Reply was hidden by moderator</span>
        @else
            <span class="body-font">
                {!! markdown($reply->reply) !!}
            </span>
        @endif
        <div class="mt-2">
            @auth
                @if (auth()->user()->hasLiked($reply))
                    <button type="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praise">
                        <span wire:loading wire:target="togglePraise" class="spinner-border spinner-border-task" role="status"></span>
                        <x-heroicon-s-thumb-up wire:loading.remove wire:target="togglePraise" class="heroicon heroicon-15px me-0" />
                        <span class="small text-white fw-bold">
                            {{ number_format($reply->likerscount()) }}
                        </span>
                        <span class="avatar-stack ms-1">
                            @foreach($reply->likers->take(5) as $user)
                                <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                            @endforeach
                        </span>
                    </button>
                @else
                    <button type="button" class="btn btn-task btn-outline-success me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praises">
                        <span wire:loading wire:target="togglePraise" class="spinner-border spinner-border-task" role="status"></span>
                        <x-heroicon-o-thumb-up wire:loading.remove wire:target="togglePraise" class="heroicon heroicon-15px me-0 text-secondary" />
                        @if ($reply->likerscount() !== 0)
                            <span class="small text-dark fw-bold">
                                {{ number_format($reply->likerscount()) }}
                            </span>
                            <span class="avatar-stack ms-1">
                                @foreach($reply->likers->take(5) as $user)
                                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                                @endforeach
                            </span>
                        @endif
                    </button>
                @endif
                @can('edit/delete', $reply)
                    <button
                        type="button"
                        class="btn btn-task btn-outline-danger"
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                        wire:click="deleteReply"
                        wire:loading.attr="disabled"
                        wire:target="deleteReply"
                        wire:offline.attr="disabled"
                        aria-label="Delete"
                    >
                        <x-heroicon-o-trash class="heroicon heroicon-15px me-0 text-secondary" />
                    </button>
                @endcan
                @can('staff.ops')
                    <button type="button" class="btn btn-task {{ $reply->hidden ? 'btn-info' : 'btn-outline-info' }} ms-1" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $reply->id }}" aria-label="Hide">
                        <x-heroicon-o-eye-off class="heroicon heroicon-15px me-0" />
                    </button>
                @endcan
            @endauth
        </div>
    </div>
</div>
