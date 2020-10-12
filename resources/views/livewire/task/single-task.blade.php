<span>
    <x-alert />
    <div class="align-items-center d-flex">
        <a href="{{ route('user.done', ['username' => $task->user->username]) }}">
            <img class="avatar-40 rounded-circle" src="{{ $task->user->avatar }}" alt="{{ $task->user->username }}" />
        </a>
        <span class="ml-2">
            <a
                href="{{ route('user.done', ['username' => $task->user->username]) }}"
                class="user-hover font-weight-bold text-dark"
                data-content=""
                data-id="{{ $task->user->id }}"
                data-html="true"
                data-toggle="popover"
                data-placement="top"
                title="{{ Emoji::fire() }} {{ number_format($task->user->getPoints()) }} {{ $task->user->getPoints(true) < 2 ? 'Reputation' : 'Reputations' }}"
            >
                @if ($task->user->firstname or $task->user->lastname)
                    {{ $task->user->firstname }}{{ ' '.$task->user->lastname }}
                @else
                    {{ $task->user->username }}
                @endif
                @if ($task->user->isVerified)
                    <i class="fa fa-check-circle ml-1 text-primary" data-toggle="tooltip" data-placement="right" title="Verified"></i>
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
        @if ($task->hidden)
        <span class="task-font font-italic text-secondary">Task was hidden by moderator</span>
        @else
        @if ($task->source === 'GitLab')
        <span>
            <i class="fab fa-gitlab task-gitlab task-font"></i>
        </span>
        @elseif ($task->source === 'GitHub')
        <span>
            <i class="fab fa-github task-github task-font"></i>
        </span>
        @elseif ($task->source === 'Webhook')
        <span>
            <i class="fa fa-globe text-info task-font"></i>
        </span>
        @else
        <input
            class="form-check-input task-checkbox"
            type="checkbox"
            wire:click="checkTask"
            {{ $task->done ? "checked" : "unchecked" }}
            {{
                Auth::check() &&
                Auth::id() === $task->user_id ?
                "enabled" : "disabled"
            }}
        />
        @if ($launched)
        <span class="ml-1">
            {{ Emoji::rocket() }}
        </span>
        @elseif ($bug)
        <span class="ml-1">
            {{ Emoji::bug() }}
        </span>
        @elseif ($learn)
        <span class="ml-1">
            {{ Emoji::greenBook() }}
        </span>
        @endif
        @endif
        <span class="ml-1 task-font @if ($launched or $bug or $learn) font-weight-bold @endif @if ($launched) text-success @endif">
            {!! Purify::clean(Helper::renderTask($task->task)) !!}
            @if ($task->type === 'product')
            <span class="small text-black-50">
                on
                <img class="rounded mb-1 ml-1 avatar-15" src="{{ $task->product->avatar }}" alt="{{ $task->product->slug }}" />
                <a class="text-black-50" href="{{ route('product.done', ['slug' => $task->product->slug]) }}">
                    {{ $task->product->name }}
                </a>
            </span>
            @endif
        </span>
        @if ($task->images)
        <div class="gallery mb-3">
        @foreach ($task->images ?? [] as $image)
        <div>
            <a href="{{ asset('storage/' . $image) }}" data-lightbox="{{ $image }}" data-title="Image by {{ '@'.$task->user->username }}">
                <img class="{{ count($task->images) === 1 ? 'w-50' : 'gallery' }} img-fluid border mt-3 rounded" src="{{ asset('storage/' . $image) }}" alt="{{ asset('storage/' . $image) }}" />
            </a>
        </div>
        @endforeach
        </div>
        @endif
        @endif
        <div class="mt-2">
            @auth
            @if (!$task->user->isPrivate)
            @if (Auth::user()->hasLiked($task))
            <button type="button" class="btn btn-task btn-success text-white mr-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $task->id }}">
                {{ Emoji::clappingHands() }}
                <span class="small text-white font-weight-bold">
                    {{ number_format($task->likerscount()) }}
                </span>
                <span class="avatar-stack ml-1">
                @foreach($task->likers->take(5) as $user)
                <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ $user->avatar }}" alt="{{ $user->username }}" />
                @endforeach
                </span>
            </button>
            @else
            <button type="button" class="btn btn-task btn-outline-success mr-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $task->id }}">
                {{ Emoji::clappingHands() }}
                @if ($task->likerscount() !== 0)
                <span class="small text-dark font-weight-bold">
                    {{ number_format($task->likerscount()) }}
                </span>
                <span class="avatar-stack ml-1">
                @foreach($task->likers->take(5) as $user)
                <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ $user->avatar }}" alt="{{ $user->username }}" />
                @endforeach
                </span>
                @endif
            </button>
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
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ $user->avatar }}" alt="{{ $user->username }}" />
                    @endforeach
                    </span>
                    @endif
                </a>
            @endguest
            <a href="{{ route('task', ['id' => $task->id]) }}" class="btn btn-task btn-outline-primary mr-1">
                {{ Emoji::speechBalloon() }}
                @if ($task->comments->count('id') !== 0)
                <span class="small text-dark font-weight-bold">
                    {{ number_format($task->comments->count('id')) }}
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
            @if (Auth::user()->staffShip)
            <button type="button" class="btn btn-task {{ $task->hidden ? 'btn-danger' : 'btn-outline-danger' }} text-white ml-1" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $task->id }}">
                {{ Emoji::triangularFlag() }}
            </button>
            @endif
            @endauth
        </div>
    </div>
    <div class="collapse mt-3 text-black-50" id="taskExpand-{{$task->id}}">
        <a class="text-black-50" href="{{ route('task', ['id' => $task->id]) }}">
            <i class="fa fa-calendar-check small mr-1"></i>
            @auth
            {{
                !$task->done_at ?
                    Carbon::parse($task->created_at)
                        ->setTimezone(Auth::user()->timezone)
                        ->format('g:i A · M d, Y') :
                    Carbon::parse($task->done_at)
                        ->setTimezone(Auth::user()->timezone)
                        ->format('g:i A · M d, Y')
            }}
            @else
            {{
                !$task->done_at ?
                    Carbon::parse($task->created_at)->format('g:i A · M d, Y') :
                    Carbon::parse($task->done_at)->format('g:i A · M d, Y')
            }}
            @endauth
            · via
            <span class="font-weight-bold">{{ $task->source }}</span>
        </a>
    </div>
</span>
