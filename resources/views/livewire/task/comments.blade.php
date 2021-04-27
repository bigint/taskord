<div wire:init="loadComments" class="pt-3">
    <div class="card">
        <div class="card-body">
            @if (!$readyToLoad)
                <div class="text-center">
                    <div class="spinner-border spinner-border-sm taskord-spinner text-secondary" role="status"></div>
                </div>
            @else
                @foreach ($comments as $comment)
                <div class="align-items-center d-flex">
                    <a href="{{ route('user.done', ['username' => $comment->user->username]) }}">
                        <img loading=lazy class="avatar-25 rounded-circle" src="{{ Helper::getCDNImage($comment->user->avatar, 80) }}" height="40" width="40" alt="{{ $comment->user->username }}'s avatar" />
                    </a>
                    <div class="ms-2">
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
                            @if ($comment->user->status)
                            <span class="ms-1 small" title="{{ $comment->user->status }}">{{ $comment->user->status_emoji }}</span>
                            @endif
                            @if ($comment->user->isVerified)
                                <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
                            @endif
                            @if ($comment->user->isPatron)
                                <a class="patron" href="{{ route('patron.home') }}" aria-label="Patron">
                                    <x-heroicon-s-star class="heroicon text-gold" />
                                </a>
                            @endif
                            <span class="small text-secondary fw-normal">{{ "@" . $comment->user->username }}</span>
                        </a>
                    </div>
                </div>
                <div class="mt-2 card d-inline-block bg-light {{ $loop->last ? '' : 'mb-3' }}">
                    <div class="card-body px-2 py-1 comment-md">
                        {!! markdown($comment->comment) !!}
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
