<span class="{{ Route::currentRouteName() === 'task' ? 'p-3' : '' }}">
    @include('components.alert')
    <div class="align-items-center d-flex">
        <a href="{{ route('user.done', ['username' => $task->user->username]) }}">
            <img class="avatar-40 rounded-circle" src="{{ asset('storage/' . $task->user->avatar) }}" />
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
            {!! Purify::clean(Helper::renderTask($task->task)) !!}
            @if ($task->type === 'product')
            <span class="small text-black-50">
                on
                <img class="rounded mb-1 ml-1 avatar-15" src="{{ $task->product->avatar }}" />
                <a class="text-black-50" href="{{ route('product.done', ['slug' => $task->product->slug]) }}">
                    {{ $task->product->name }}
                </a>
            </span>
            @endif
        </span>
        @if ($task->image)
        <div>
            <img class="img-fluid border mt-3 rounded" src="{{ asset('storage/' . $task->image) }}" />
        </div>
        @endif
        <div class="mt-2">
            @auth
            @if (!$task->user->isPrivate)
            @if (Auth::user()->hasLiked($task))
            <span>
                <button type="button" class="btn btn-task btn-success text-white mr-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $task->id }}">
                    {{ Emoji::clappingHands() }}
                    <span class="small text-white font-weight-bold">
                        {{ number_format($task->likerscount()) }}
                    </span>
                    <span class="avatar-stack ml-1">
                    @foreach($task->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ asset('storage/' . $user->avatar) }}" />
                    @endforeach
                    </span>
                </button>
            </span>
            @else
            <span>
                <button type="button" class="btn btn-task btn-outline-success mr-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $task->id }}">
                    {{ Emoji::clappingHands() }}
                    @if ($task->likerscount() !== 0)
                    <span class="small text-dark font-weight-bold">
                        {{ number_format($task->likerscount()) }}
                    </span>
                    <span class="avatar-stack ml-1">
                    @foreach($task->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ asset('storage/' . $user->avatar) }}" />
                    @endforeach
                    </span>
                    @endif
                </button>
            </span>
            @endif
            @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success mr-1">
                    {{ Emoji::clappingHands() }}
                    @if ($task->likerscount() !== 0)
                    <span class="small text-dark font-weight-bold">
                        {{ number_format($task->likerscount()) }}
                    </span>
                    <span class="avatar-stack ml-1">
                    @foreach($task->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ asset('storage/' . $user->avatar) }}" />
                    @endforeach
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
                <button type="button" class="btn btn-task btn-danger" wire:click="deleteTask" wire:loading.attr="disabled" wire:offline.attr="disabled">
                    Are you sure?
                    <span wire:target="deleteTask" wire:loading class="spinner-border spinner-border-mini ml-2" role="status"></span>
                </button>
                @else
                <button type="button" class="btn btn-task btn-outline-danger" wire:click="confirmDelete" wire:loading.attr="disabled" wire:offline.attr="disabled">
                    {{ Emoji::wastebasket() }}
                </button>
                @endif
            @endif
            @endauth
        </div>
    </div>
    <div class="collapse mt-3 text-black-50" id="taskExpand-{{$task->id}}">
        <a class="text-black-50" href="{{ route('task', ['id' => $task->id]) }}">
            <i class="fa fa-calendar-check small mr-1"></i>
            {{
                !$task->done_at ?
                    Carbon::parse($task->created_at)->format('g:i A · M d, Y') :
                    Carbon::parse($task->done_at)->format('g:i A · M d, Y')
            }}
            · via
            <span class="font-weight-bold">{{ $task->source }}</span>
        </a>
    </div>
</span>
