<li class="list-group-item p-3">
    <x-alert />
    <div class="align-items-center d-flex mb-2">
        <a href="{{ route('user.done', ['username' => $comment->user->username]) }}">
            <img class="avatar-30 rounded-circle" src="{{ $comment->user->avatar }}" />
        </a>
        <span class="ml-2">
            <a
                href="{{ route('user.done', ['username' => $comment->user->username]) }}"
                class="font-weight-bold text-dark"
                id="user-hover"
                data-id="{{ $comment->user->id }}"
            >
                @if ($comment->user->firstname or $comment->user->lastname)
                    {{ $comment->user->firstname }}{{ ' '.$comment->user->lastname }}
                @else
                    {{ $comment->user->username }}
                @endif
                @if ($comment->user->isVerified)
                    <i class="fa fa-check-circle ml-1 text-primary" data-toggle="tooltip" data-placement="right" title="Verified"></i>
                @endif
                @if ($comment->user->isPatron)
                    <a class="ml-1 small" href="{{ route('patron.home') }}" data-toggle="tooltip" data-placement="right" title="Patron">
                        {{ Emoji::handshake() }}
                    </a>
                @endif
            </a>
        </span>
        <a
            class="align-text-top small float-right ml-auto text-black-50"
            href="{{ route('comment', ['id' => $comment->task->id, 'comment_id' => $comment->id]) }}"
        >
            {{ Carbon::parse($comment->created_at)->diffForHumans() }}
        </a>
    </div>
    @if ($comment->hidden)
    <span class="body-font font-italic text-secondary">Comment was hidden by moderator</span>
    @else
    <span class="body-font">
        {!! nl2br(Purify::clean(Helper::renderTask($comment->comment))) !!}
    </span>
    @endif
    <div class="mt-2">
        @auth
        @if (Auth::user()->hasLiked($comment))
            <button type="button" class="btn btn-task btn-success text-white mr-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled">
                {{ Emoji::clappingHands() }}
                <span class="small text-white font-weight-bold">
                    {{ number_format($comment->likerscount()) }}
                </span>
                <span class="avatar-stack ml-1">
                @foreach($comment->likers->take(5) as $user)
                <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ $user->avatar }}" />
                @endforeach
                </span>
            </button>
        @else
            <button type="button" class="btn btn-task btn-outline-success mr-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled">
                {{ Emoji::clappingHands() }}
                @if ($comment->likerscount() !== 0)
                <span class="small text-dark font-weight-bold">
                    {{ number_format($comment->likerscount()) }}
                </span>
                <span class="avatar-stack ml-1">
                @foreach($comment->likers->take(5) as $user)
                <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ $user->avatar }}" />
                @endforeach
                </span>
                @endif
            </button>
        @endif
        @if (Auth::user()->staffShip or Auth::id() === $comment->user->id)
            @if ($confirming === $comment->id)
            <button type="button" class="btn btn-task btn-danger" wire:click="deleteComment" wire:loading.attr="disabled" wire:offline.attr="disabled">
                Are you sure?
                <span wire:target="deleteComment" wire:loading class="spinner-border spinner-border-mini ml-2" role="status"></span>
            </button>
            @else
            <button type="button" class="btn btn-task btn-outline-danger" wire:click="confirmDelete" wire:loading.attr="disabled" wire:offline.attr="disabled">
                {{ Emoji::wastebasket() }}
            </button>
            @endif
        @endif
        @if (Auth::user()->staffShip)
        <button type="button" class="btn btn-task {{ $comment->hidden ? 'btn-danger' : 'btn-outline-danger' }} text-white ml-1" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $comment->id }}">
            {{ Emoji::triangularFlag() }}
        </button>
        @endif
        @endauth
        @guest
            <a href="/login" class="btn btn-task btn-outline-success mr-1">
                {{ Emoji::clappingHands() }}
                @if ($comment->likerscount() !== 0)
                <span class="small text-dark font-weight-bold">
                    {{ number_format($comment->likerscount()) }}
                </span>
                <span class="avatar-stack ml-1">
                @foreach($comment->likers->take(5) as $user)
                <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ $user->avatar }}" />
                @endforeach
                </span>
                @endif
            </a>
        @endguest
    </div>
</li>
