<li class="list-group-item p-3">
    @include('components.alert')
    <div class="align-items-center d-flex">
        <a href="{{ route('user.done', ['username' => $task->user->username]) }}">
            <img class="avatar-40 rounded-circle" src="{{ $task->user->avatar }}" />
        </a>
        <span class="ml-2">
            <a href="{{ route('user.done', ['username' => $task->user->username]) }}" class="font-weight-bold text-dark">
                @if ($task->user->firstname or $task->user->lastname)
                    {{ $task->user->firstname }}{{ ' '.$task->user->lastname }}
                @else
                    {{ $task->user->username }}
                @endif
                @if ($task->user->isPatron)
                    <a class="ml-1 small" href="{{ route('patron.home') }}" data-toggle="tooltip" data-placement="right" title="Patron">
                        {{ Emoji::handshake() }}
                    </a>
                @endif
            </a>
            <a class="text-black-50" href="{{ route('user.done', ['username' => $task->user->username]) }}">
                <div class="small">{{ "@" . $task->user->username }}</div>
            </a>
        </span>
        <span class="align-text-top small float-right ml-auto text-black-50" type="button" data-toggle="collapse" data-target="#taskExpand-{{$task->id}}" aria-expanded="false">
            {{ !$task->done_at ? Carbon::parse($task->created_at)->diffForHumans() : Carbon::parse($task->done_at)->diffForHumans() }}
        </span>
    </div>
    <div class="mt-3 mb-1">
        <input
            class="form-check-input"
            type="checkbox"
            wire:click="checkTask"
            {{ $task->done ? "checked" : "unchecked" }}
            {{
                Auth::check() &&
                Auth::id() === $task->user_id ?
                "enabled" : "disabled"
            }}
        />
        <span class="ml-1 task-font">
            {!!
                Purify::clean(
                    preg_replace('/@(\w+)/',  
                        '<a href="@$1">@$1</a>', 
                        preg_replace('/#(\w+)/',
                            '<a href="product/$1">#$1</a>',
                        $task->task)
                    )
                )
            !!}
        </span>
        @if ($task->image)
        <div>
            <img class="img-fluid border mt-3 rounded" src="{{ asset('storage/' . $task->image) }}" />
        </div>
        @endif
        <div class="mt-2">
            @auth
            @if (Auth::user()->hasLiked($task))
                <button type="button" class="btn btn-task btn-success text-white mr-1" wire:click="togglePraise" wire:loading.attr="disabled">
                    {{ Emoji::clappingHands() }}
                    <span class="small text-dark font-weight-bold">
                        {{ number_format($task->likes()->count('id')) }}
                    </span>
                </button>
            @else
                <button type="button" class="btn btn-task btn-outline-success mr-1" wire:click="togglePraise" wire:loading.attr="disabled">
                    {{ Emoji::clappingHands() }}
                    @if ($task->likes()->count('id') !== 0)
                    <span class="small text-dark font-weight-bold">
                        {{ number_format($task->likes()->count('id')) }}
                    </span>
                    @endif
                </button>
            @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success mr-1">
                    {{ Emoji::clappingHands() }}
                    @if ($task->likes()->count('id') !== 0)
                    <span class="small text-dark font-weight-bold">
                        {{ number_format($task->likes()->count('id')) }}
                    </span>
                    @endif
                </a>
            @endguest
            <a href="{{ route('task', ['id' => $task->id]) }}" class="btn btn-task btn-outline-primary mr-1">
                {{ Emoji::speechBalloon() }}
                @if ($task->comment->count('id') !== 0)
                <span class="small text-dark font-weight-bold">
                    {{ number_format($task->comment->count('id')) }}
                </span>
                @endif
            </a>
            @auth
            @if (Auth::user()->staffShip or Auth::id() === $task->user->id)
                @if ($confirming === $task->id)
                <button type="button" class="btn btn-task btn-danger" wire:click="deleteTask" wire:loading.attr="disabled">
                    Are you sure?
                    <span wire:target="deleteTask" wire:loading class="spinner-border spinner-border-mini ml-2" role="status"></span>
                </button>
                @else
                <button type="button" class="btn btn-task btn-outline-danger" wire:click="confirmDelete" wire:loading.attr="disabled">
                    {{ Emoji::wastebasket() }}
                </button>
                @endif
            @endif
            @endauth
        </div>
    </div>
    <div class="collapse mt-3 text-black-50" id="taskExpand-{{$task->id}}">
        <a class="text-black-50" href="{{ route('task', ['id' => $task->id]) }}">
            {{
                !$task->done_at ?
                    Carbon::parse($task->created_at)->format('g:i A · M d, Y') :
                    Carbon::parse($task->done_at)->format('g:i A · M d, Y')
            }}
        </a>
    </div>
</li>
