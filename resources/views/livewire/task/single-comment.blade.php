<li class="list-group-item pt-3 pb-3">
    @include('components.alert')
    <div class="align-items-center d-flex mb-2">
        <img class="avatar-40 rounded-circle" src="{{ $comment->user->avatar }}" />
        <span class="ml-2">
            <a href="{{ route('user.done', ['username' => $comment->user->username]) }}" class="font-weight-bold text-dark">
                @if ($comment->user->firstname or $comment->user->lastname)
                    {{ $comment->user->firstname }}{{ ' '.$comment->user->lastname }}
                @else
                    {{ $comment->user->username }}
                @endif
            </a>
            <div class="small">{{ "@" . $comment->user->username }}</div>
        </span>
        <span class="align-text-top small float-right ml-auto">
            {{ Carbon::parse($comment->created_at)->diffForHumans() }}
        </span>
    </div>
    <span class="task-font">
        @markdown($comment->comment)
    </span>
    <div>
        @auth
        @if (Auth::user()->hasLiked($comment))
            <button type="button" class="btn btn-task btn-success text-white mr-1" wire:click="togglePraise" wire:loading.attr="disabled">
                {{ Emoji::clappingHands() }}
                <span class="small text-dark font-weight-bold">
                    {{ $comment->likes()->count('id') }}
                </span>
            </button>
        @else
            <button type="button" class="btn btn-task btn-outline-success mr-1" wire:click="togglePraise" wire:loading.attr="disabled">
                {{ Emoji::clappingHands() }}
                @if ($comment->likes()->count('id') !== 0)
                <span class="small text-dark font-weight-bold">
                    {{ $comment->likes()->count('id') }}
                </span>
                @endif
            </button>
        @endif
        @if (Auth::user()->staffShip or Auth::id() === $comment->user->id)
            @if ($confirming === $comment->id)
            <button type="button" class="btn btn-task btn-danger" wire:click="deleteTaskComment" wire:loading.attr="disabled">
                Are you sure?
                <span wire:target="deleteTaskComment" wire:loading class="spinner-border spinner-border-mini ml-2" role="status"></span>
            </button>
            @else
            <button type="button" class="btn btn-task btn-outline-danger" wire:click="confirmDelete" wire:loading.attr="disabled">
                {{ Emoji::wastebasket() }}
            </button>
            @endif
        @endif
        @endauth
        @guest
            <a href="/login" class="btn btn-task btn-outline-success mr-1">
                {{ Emoji::clappingHands() }}
                @if ($comment->likes()->count('id') !== 0)
                <span class="small text-dark font-weight-bold">
                    {{ $comment->likes()->count('id') }}
                </span>
                @endif
            </a>
        @endguest
    </div>
</li>
