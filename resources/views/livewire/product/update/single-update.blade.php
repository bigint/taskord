<div class="card mb-4">
    <div class="card-header d-flex align-items-center h6 pt-3 pb-3">
        <a href="{{ route('user.done', ['username' => $update->user->username]) }}">
            <img class="avatar-30 rounded-circle" src="{{ $update->user->avatar }}" />
        </a>
        <span class="ml-2">
            <a href="{{ route('user.done', ['username' => $update->user->username]) }}" class="font-weight-bold text-dark">
                @if ($update->user->firstname or $update->user->lastname)
                    {{ $update->user->firstname }}{{ ' '.$update->user->lastname }}
                @else
                    {{ $update->user->username }}
                @endif
                @if ($update->user->isVerified)
                <i class="fa fa-check-circle ml-2 text-primary" title="Verified"></i>
                @endif
                @if ($update->user->isPatron)
                    <a class="ml-1 small" href="{{ route('patron.home') }}" data-toggle="tooltip" data-placement="right" title="Patron">
                        {{ Emoji::handshake() }}
                    </a>
                @endif
            </a>
        </span>
    </div>
    <div class="card-body">
        <x-alert />
        <div>@markdown($update->body)</div>
        <div class="mt-2">
            @auth
            @if (!$update->user->isPrivate)
            @if (Auth::user()->hasLiked($update))
            <span>
                <button type="button" class="btn btn-task btn-success text-white mr-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $update->id }}">
                    {{ Emoji::clappingHands() }}
                    <span class="small text-white font-weight-bold">
                        {{ number_format($update->likerscount()) }}
                    </span>
                    <span class="avatar-stack ml-1">
                    @foreach($update->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ $user->avatar }}" />
                    @endforeach
                    </span>
                </button>
            </span>
            @else
            <span>
                <button type="button" class="btn btn-task btn-outline-success mr-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $update->id }}">
                    {{ Emoji::clappingHands() }}
                    @if ($update->likerscount() !== 0)
                    <span class="small text-dark font-weight-bold">
                        {{ number_format($update->likerscount()) }}
                    </span>
                    <span class="avatar-stack ml-1">
                    @foreach($update->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ $user->avatar }}" />
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
                    @if ($update->likerscount() !== 0)
                    <span class="small text-dark font-weight-bold">
                        {{ number_format($update->likerscount()) }}
                    </span>
                    <span class="avatar-stack ml-1">
                    @foreach($update->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ $user->avatar }}" />
                    @endforeach
                    </span>
                    @endif
                </a>
            @endguest
            @auth
            @if (Auth::user()->staffShip or Auth::id() === $update->user->id)
                @if ($confirming === $update->id)
                <button type="button" class="btn btn-task btn-danger" wire:click="deleteUpdate" wire:loading.attr="disabled" wire:offline.attr="disabled">
                    Are you sure?
                    <span wire:target="deleteUpdate" wire:loading class="spinner-border spinner-border-mini ml-2" role="status"></span>
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
</div>
