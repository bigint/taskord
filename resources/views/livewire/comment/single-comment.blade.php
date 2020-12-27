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
                    <a class="patron" href="{{ route('patron.home') }}" data-turbolinks="false" aria-label="Patron">
                        <x-heroicon-s-star class="heroicon text-gold" />
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
        {!! Markdown::parse($comment->comment) !!}
    </span>
    @endif
    <div class="mt-2">
        @auth
        @if (Auth::user()->hasLiked($comment))
            <button type="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praise">
                <x-heroicon-s-thumb-up class="heroicon-small me-0" />
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
                <x-heroicon-o-thumb-up class="heroicon-small me-0" />
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
            <button type="button" class="btn btn-task btn-danger" wire:click="deleteComment" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Confirm Delete">
                Are you sure?
            </button>
            @else
            <button type="button" class="btn btn-task btn-outline-danger" wire:click="confirmDelete" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Delete">
                <x-heroicon-o-trash class="heroicon-small me-0" />
            </button>
            @endif
        @endif
        @if (Auth::user()->staffShip)
        <button type="button" class="btn btn-task {{ $comment->hidden ? 'btn-dark' : 'btn-outline-dark' }} ms-1" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $comment->id }}" title="Flag to admins" aria-label="Hide">
            <x-heroicon-o-eye-off class="heroicon-small me-0" />
        </button>
        @endif
        @endauth
        @guest
            <a href="/login" class="btn btn-task btn-outline-success me-1" aria-label="Praises">
                <x-heroicon-o-thumb-up class="heroicon-small me-0" />
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
