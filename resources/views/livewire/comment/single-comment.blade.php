<li class="list-group-item p-3">
    <div class="align-items-center d-flex mb-2">
        <a href="{{ route('user.done', ['username' => $comment->user->username]) }}">
            <img loading=lazy class="avatar-30 rounded-circle" src="{{ $comment->user->avatar }}" height="30" width="30" alt="{{ $comment->user->username }}'s avatar" />
        </a>
        <span class="ms-2">
            <a
                href="{{ route('user.done', ['username' => $comment->user->username]) }}"
                class="fw-bold text-dark user-popover"
                data-id="{{ $comment->user->id }}"
            >
                @if ($comment->user->firstname or $comment->user->lastname)
                    {{ $comment->user->firstname }}{{ ' '.$comment->user->lastname }}
                @else
                    {{ $comment->user->username }}
                @endif
                @if ($comment->user->isVerified)
                    <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
                @endif
                @if ($comment->user->isPatron)
                    <a class="patron ms-1 small" href="{{ route('patron.home') }}">
                        🤝
                    </a>
                @endif
            </a>
        </span>
        <a
            class="align-text-top small float-end ms-auto text-secondary"
            href="{{ route('comment', ['id' => $comment->task->id, 'comment_id' => $comment->id]) }}"
        >
            {{ Carbon::parse($comment->created_at)->diffForHumans() }}
        </a>
    </div>
    @if ($comment->hidden)
    <span class="body-font fst-italic text-secondary">Comment was hidden by moderator</span>
    @else
    <span class="body-font">
        @parsedown($comment->comment)
    </span>
    @endif
    <div class="mt-2">
        @auth
        @if (Auth::user()->hasLiked($comment))
            <button type="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled">
                👏
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
            <button type="button" class="btn btn-task btn-outline-success me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled">
                👏
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
        @if (Auth::user()->staffShip or Auth::id() === $comment->user->id)
            @if ($confirming === $comment->id)
            <button type="button" class="btn btn-task btn-danger" wire:click="deleteComment" wire:loading.attr="disabled" wire:offline.attr="disabled">
                Are you sure?
                <span wire:target="deleteComment" wire:loading class="spinner-border spinner-border-mini ms-2" role="status"></span>
            </button>
            @else
            <button type="button" class="btn btn-task btn-outline-danger" wire:click="confirmDelete" wire:loading.attr="disabled" wire:offline.attr="disabled">
                🗑
            </button>
            @endif
        @endif
        @if (Auth::user()->staffShip)
        <button type="button" class="btn btn-task {{ $comment->hidden ? 'btn-danger' : 'btn-outline-danger' }} text-white ms-1" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $comment->id }}" title="Flag to admins">
            🤢
        </button>
        @endif
        @endauth
        @guest
            <a href="/login" class="btn btn-task btn-outline-success me-1">
                👏
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
</li>
