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
                @if (auth()->user()->staff_mode or auth()->user()->id === $reply->user->id)
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
                @endif
                @can('staff_mode')
                    <button type="button" class="btn btn-task {{ $reply->hidden ? 'btn-info' : 'btn-outline-info' }} ms-1" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $reply->id }}" aria-label="Hide">
                        <x-heroicon-o-eye-off class="heroicon heroicon-15px me-0" />
                    </button>
                @endcan
            @endauth
        </div>
    </div>
</div>
