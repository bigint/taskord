<div class="card">
    <div class="card-body">
        <div class="align-items-center d-flex mb-2">
            <x:shared.user-label-small :user="$comment->user" />
            <a class="align-text-top small float-end ms-auto text-secondary"
                href="{{ route('comment', ['id' => $comment->task->id, 'comment_id' => $comment->id]) }}">
                {{ carbon($comment->created_at)->diffForHumans() }}
            </a>
        </div>
        @if ($comment->hidden)
            <span class="body-font fst-italic text-secondary">Comment was hidden by moderator</span>
        @else
            @if ($edit)
                <div class="mt-3">
                    <livewire:comment.edit-comment :comment="$comment" />
                </div>
            @else
                <span class="body-font">
                    {!! markdown($comment->comment) !!}
                </span>
            @endif
        @endif
        <div class="mt-2">
            @auth
                <x:like-button :entity="$comment" />
                <button class="btn btn-action btn-outline-primary me-1" wire:click="toggleCommentBox">
                    <x-heroicon-o-chat-alt class="heroicon heroicon-15px me-0 text-secondary" />
                    @if ($comment->replies()->count('id') !== 0)
                        <span class="small text-dark fw-bold">
                            {{ number_format($comment->replies()->count('id')) }}
                        </span>
                    @endif
                </button>
                @can('edit/delete', $comment)
                    <button type="button" class="btn btn-action btn-outline-primary me-1" wire:click="editComment"
                        wire:loading.attr="disabled" aria-label="Edit">
                        <x-heroicon-o-pencil class="heroicon heroicon-15px me-0 text-secondary" />
                    </button>
                    <button type="button" class="btn btn-action btn-outline-danger"
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteComment"
                        wire:loading.attr="disabled" aria-label="Delete">
                        <x-heroicon-o-trash class="heroicon heroicon-15px me-0 text-secondary" />
                    </button>
                @endcan
                @can('staff.ops')
                    <button type="button" class="btn btn-action {{ $comment->hidden ? 'btn-info' : 'btn-outline-info' }} ms-1"
                        wire:click="hide" wire:loading.attr="disabled" wire:key="{{ $comment->id }}" aria-label="Hide">
                        <x-heroicon-o-eye-off class="heroicon heroicon-15px me-0" />
                    </button>
                @endcan
            @endauth
            @guest
                <a href="/login" class="btn btn-action btn-outline-like me-1" aria-label="Likes">
                    <x-heroicon-o-heart class="heroicon heroicon-15px me-0" />
                    @if ($comment->likerscount() !== 0)
                        <span class="small fw-bold">
                            {{ number_format($comment->likerscount()) }}
                        </span>
                    @endif
                </a>
            @endguest
        </div>
    </div>
    <div class="bg-light rounded-bottom {{ $comment->replies()->count('id') > 0 ? 'border-1 border-top' : '' }}">
        <div class="px-3">
            <livewire:comment.reply.replies :comment="$comment" />
        </div>
        @auth
            @if ($showReplyBox)
                <div class="px-3 pb-3">
                    <livewire:comment.reply.create-reply :comment="$comment" />
                </div>
            @else
                <div class="p-2 border-1 border-top d-flex align-items-center">
                    <a href="{{ route('user.done', ['username' => auth()->user()->username]) }}" class="user-popover ms-2"
                        data-id="{{ auth()->id() }}">
                        <img loading=lazy class="avatar-25 rounded-circle"
                            src="{{ Helper::getCDNImage(auth()->user()->avatar, 80) }}" height="40" width="40"
                            alt="{{ auth()->user()->username }}'s avatar" />
                    </a>
                    <div class="ms-2 w-100 btn btn-sm border-1 border-reply text-dark text-start bg-white"
                        wire:click="toggleCommentBox">
                        Reply now
                    </div>
                </div>
                <div wire:loading wire:target="toggleCommentBox">
                    <div class="spinner-border spinner-border-sm taskord-spinner text-secondary m-3" role="status"></div>
                </div>
            @endif
        @endauth
    </div>
</div>
