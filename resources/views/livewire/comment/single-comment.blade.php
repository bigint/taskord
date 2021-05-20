<div class="card">
    <div class="card-body">
        <div class="align-items-center d-flex mb-2">
            <x:shared.user-label-small :user="$comment->user" />
            <a
                class="align-text-top small float-end ms-auto text-secondary"
                href="{{ route('comment', ['id' => $comment->task->id, 'comment_id' => $comment->id]) }}"
            >
                {{ carbon($comment->created_at)->diffForHumans() }}
            </a>
        </div>
        @if ($comment->hidden)
            <span class="body-font fst-italic text-secondary">Comment was hidden by moderator</span>
        @else
            <span class="body-font">
                {!! markdown($comment->comment) !!}
            </span>
        @endif
        <div class="mt-2">
            @auth
                @if (auth()->user()->hasLiked($comment))
                    <button type="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praise">
                        <x-heroicon-s-thumb-up class="heroicon heroicon-15px me-0" />
                        <span class="small text-white fw-bold">
                            {{ number_format($comment->likerscount()) }}
                        </span>
                        <span class="avatar-stack ms-1">
                            @foreach($comment->likers->take(5) as $user)
                                <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                            @endforeach
                        </span>
                    </button>
                @else
                    <button type="button" class="btn btn-task btn-outline-success me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praises">
                        <x-heroicon-o-thumb-up class="heroicon heroicon-15px me-0 text-secondary" />
                        @if ($comment->likerscount() !== 0)
                            <span class="small text-dark fw-bold">
                                {{ number_format($comment->likerscount()) }}
                            </span>
                            <span class="avatar-stack ms-1">
                                @foreach($comment->likers->take(5) as $user)
                                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                                @endforeach
                            </span>
                        @endif
                    </button>
                @endif
                <button class="btn btn-task btn-outline-primary me-1" wire:click="toggleCommentBox">
                    <x-heroicon-o-chat-alt class="heroicon heroicon-15px me-0 text-secondary" />
                    @if ($comment->replies()->count('id') !== 0)
                        <span class="small text-dark fw-bold">
                            {{ number_format($comment->replies()->count('id')) }}
                        </span>
                    @endif
                </button>
                @if (auth()->user()->staffShip or auth()->user()->id === $comment->user->id)
                    <button
                        type="button"
                        class="btn btn-task btn-outline-danger"
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                        wire:click="deleteComment"
                        wire:loading.attr="disabled"
                        wire:offline.attr="disabled"
                        aria-label="Delete"
                    >
                        <x-heroicon-o-trash class="heroicon heroicon-15px me-0 text-secondary" />
                    </button>
                @endif
                @if (auth()->user()->staffShip)
                    <button type="button" class="btn btn-task {{ $comment->hidden ? 'btn-info' : 'btn-outline-info' }} ms-1" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $comment->id }}" title="Flag to admins" aria-label="Hide">
                        <x-heroicon-o-eye-off class="heroicon heroicon-15px me-0" />
                    </button>
                @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success me-1" aria-label="Praises">
                    <x-heroicon-o-thumb-up class="heroicon heroicon-15px me-0 text-secondary" />
                    @if ($comment->likerscount() !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($comment->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($comment->likers->take(5) as $user)
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                    @endforeach
                    </span>
                    @endif
                </a>
            @endguest
        </div>
    </div>
    <div class="bg-light">
        <div class="px-3">
            <livewire:comment.reply.replies :comment="$comment" />
        </div>
        @auth
            @if ($showReplyBox)
                <div class="px-3 {{ $comment->replies()->count() > 0 ? 'mb-3' : 'my-3' }}">
                    <livewire:comment.reply.create-reply :comment="$comment" />
                </div>
            @else
                <div class="p-2 border-1 border-top d-flex align-items-center">
                    <a
                        href="{{ route('user.done', ['username' => auth()->user()->username]) }}"
                        class="user-popover ms-2"
                        data-id="{{ auth()->id() }}"
                    >
                        <img loading=lazy class="avatar-25 rounded-circle" src="{{ Helper::getCDNImage(auth()->user()->avatar, 80) }}" height="40" width="40" alt="{{ auth()->user()->username }}'s avatar" />
                    </a>
                    <div class="ms-2 w-100 btn btn-sm border-1 border-reply text-dark text-start bg-white" wire:click="toggleCommentBox">
                        Reply now
                    </div>
                </div>
            @endif
        @endauth
    </div>
</div>
