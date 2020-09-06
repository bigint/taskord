<li class="list-group-item pt-3">
    @include('components.alert')
    <div class="align-items-center d-flex mb-2">
        <img class="avatar-30 rounded-circle" src="{{ $comment->user->avatar }}" />
        <span class="ml-2">
            <a href="{{ route('user.done', ['username' => $comment->user->username]) }}" class="font-weight-bold text-dark">
                @if ($comment->user->firstname or $comment->user->lastname)
                    {{ $comment->user->firstname }}{{ ' '.$comment->user->lastname }}
                @else
                    {{ $comment->user->username }}
                @endif
            </a>
        </span>
        <span class="align-text-top small float-right ml-auto text-black-50">
            {{ Carbon::parse($comment->created_at)->diffForHumans() }}
        </span>
    </div>
    <div class="d-flex">
        <span class="task-font">
            @markdown($comment->comment)
        </span>
        <span class="ml-2">
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
        </span>
    </div>
</li>
