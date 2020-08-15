<div>
    <div class="card-body">
        @include('components.alert')
        <div class="d-flex align-items-center">
            <a href="{{ route('user.done', ['username' => $answer->user->username]) }}">
                <img class="avatar-40 rounded-circle" src="{{ $answer->user->avatar }}" />
            </a>
            <span class="ml-2">
                <a href="{{ route('user.done', ['username' => $answer->user->username]) }}" class="font-weight-bold text-dark">
                    @if ($answer->user->firstname or $answer->user->lastname)
                        {{ $answer->user->firstname }}{{ ' '.$answer->user->lastname }}
                    @else
                        {{ $answer->user->username }}
                    @endif
                    @if ($answer->user->isPatron)
                        <a class="ml-1 small" href="{{ route('patron.home') }}" data-toggle="tooltip" data-placement="right" title="Patron">
                            {{ Emoji::handshake() }}
                        </a>
                    @endif
                </a>
                <div class="small">{{ "@" . $answer->user->username }}</div>
            </span>
            <span class="align-text-top small float-right ml-auto">
                <a class="text-black-50" href="">
                    {{ Carbon::parse($answer->created_at)->diffForHumans() }}
                </a>
            </span>
        </div>
    </div>
    <div class="card-body pt-1">
        <div>@markdown($answer->answer)</div>
        <div class="mt-3">
            @auth
            @if (Auth::user()->hasLiked($answer))
                <button type="button" class="btn btn-task btn-success text-white mr-1" wire:click="togglePraise" wire:loading.attr="disabled">
                    {{ Emoji::clappingHands() }}
                    <span class="small text-white font-weight-bold">
                        {{ number_format($answer->likes()->count('id')) }}
                    </span>
                </button>
            @else
                <button type="button" class="btn btn-task btn-outline-success mr-1" wire:click="togglePraise" wire:loading.attr="disabled">
                    {{ Emoji::clappingHands() }}
                    @if ($answer->likes()->count('id') !== 0)
                    <span class="small text-dark font-weight-bold">
                        {{ number_format($answer->likes()->count('id')) }}
                    </span>
                    @endif
                </button>
            @endif
            @if (Auth::user()->staffShip or Auth::id() === $answer->user->id)
                @if ($confirming === $answer->id)
                <button type="button" class="btn btn-task btn-danger mr-1" wire:click="deleteAnswer" wire:loading.attr="disabled">
                    Are you sure?
                    <span wire:target="deleteAnswer" wire:loading class="spinner-border spinner-border-mini ml-2" role="status"></span>
                </button>
                @else
                <button type="button" class="btn btn-task btn-outline-danger mr-1" wire:click="confirmDelete" wire:loading.attr="disabled">
                    {{ Emoji::wastebasket() }}
                </button>
                @endif
            @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success mr-1">
                    {{ Emoji::clappingHands() }}
                    @if ($answer->likes()->count('id') !== 0)
                    <span class="small text-dark font-weight-bold">
                        {{ number_format($answer->likes()->count('id')) }}
                    </span>
                    @endif
                </a>
            @endguest
        </div>
    </div>
</div>