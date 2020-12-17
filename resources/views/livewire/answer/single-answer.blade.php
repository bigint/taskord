<div>
    <div class="card-body">
        <x-alert />
        <div class="d-flex align-items-center">
            <a href="{{ route('user.done', ['username' => $answer->user->username]) }}">
                <img class="avatar-40 rounded-circle" src="{{ $answer->user->avatar }}" />
            </a>
            <span class="ms-2">
                <a
                    href="{{ route('user.done', ['username' => $answer->user->username]) }}"
                    class="fw-bold text-dark"
                    id="user-hover"
                    data-id="{{ $answer->user->id }}"
                >
                    @if ($answer->user->firstname or $answer->user->lastname)
                        {{ $answer->user->firstname }}{{ ' '.$answer->user->lastname }}
                    @else
                        {{ $answer->user->username }}
                    @endif
                    @if ($answer->user->isVerified)
                    <i class="verified fa fa-check-circle ms-1 text-primary"></i>
                    @endif
                    @if ($answer->user->isPatron)
                        <a class="patron ms-1 small" href="{{ route('patron.home') }}">
                            🤝
                        </a>
                    @endif
                </a>
                <div class="small">{{ "@" . $answer->user->username }}</div>
            </span>
            <span class="align-text-top small float-end ms-auto">
                <a class="text-black-50" href="">
                    {{ Carbon::parse($answer->created_at)->diffForHumans() }}
                </a>
            </span>
        </div>
    </div>
    <div class="card-body pt-1">
        @if ($answer->hidden)
        <span class="body-font fst-italic text-secondary">Answer was hidden by moderator</span>
        @else
        <div class="body-font">
            {!! nl2br(Purify::clean(Helper::renderTask($answer->answer))) !!}
        </div>
        @endif
        <div class="mt-2">
            @auth
            @if (Auth::user()->hasLiked($answer))
                <button type="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled">
                    👏
                    <span class="small text-white fw-bold">
                        {{ number_format($answer->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($answer->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ $user->avatar }}" />
                    @endforeach
                    </span>
                </button>
            @else
                <button type="button" class="btn btn-task btn-outline-success me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled">
                    👏
                    @if ($answer->likerscount() !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($answer->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($answer->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ $user->avatar }}" />
                    @endforeach
                    </span>
                    @endif
                </button>
            @endif
            @if (Auth::user()->staffShip or Auth::id() === $answer->user->id)
                @if ($confirming === $answer->id)
                <button type="button" class="btn btn-task btn-danger me-1" wire:click="deleteAnswer" wire:loading.attr="disabled" wire:offline.attr="disabled">
                    Are you sure?
                    <span wire:target="deleteAnswer" wire:loading class="spinner-border spinner-border-mini ms-2" role="status"></span>
                </button>
                @else
                <button type="button" class="btn btn-task btn-outline-danger me-1" wire:click="confirmDelete" wire:loading.attr="disabled" wire:offline.attr="disabled">
                    🗑
                </button>
                @endif
            @endif
            @if (Auth::user()->staffShip)
            <button type="button" class="btn btn-task {{ $answer->hidden ? 'btn-danger' : 'btn-outline-danger' }} text-white ms-1" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $answer->id }}" title="Flag to admins">
                🤢
            </button>
            @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success me-1">
                    👏
                    @if ($answer->likerscount() !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($answer->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($answer->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ $user->avatar }}" />
                    @endforeach
                    </span>
                    @endif
                </a>
            @endguest
        </div>
    </div>
</div>
