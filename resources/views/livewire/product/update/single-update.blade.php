<div class="card mb-4">
    <div class="card-header d-flex align-items-center h6 pt-3 pb-3">
        <a href="{{ route('user.done', ['username' => $update->user->username]) }}">
            <img class="avatar-30 rounded-circle" src="{{ $update->user->avatar }}" />
        </a>
        <span class="ms-2">
            <a href="{{ route('user.done', ['username' => $update->user->username]) }}" class="fw-bold text-dark">
                @if ($update->user->firstname or $update->user->lastname)
                    {{ $update->user->firstname }}{{ ' '.$update->user->lastname }}
                @else
                    {{ $update->user->username }}
                @endif
                @if ($update->user->isVerified)
                <i class="verified fa fa-check-circle ms-1 text-primary"></i>
                @endif
                @if ($update->user->isPatron)
                    <a class="patron ms-1 small" href="{{ route('patron.home') }}">
                        🤝
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
                <button type="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $update->id }}">
                    👏
                    <span class="small text-white fw-bold">
                        {{ number_format($update->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($update->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ $user->avatar }}" />
                    @endforeach
                    </span>
                </button>
            </span>
            @else
            <span>
                <button type="button" class="btn btn-task btn-outline-success me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $update->id }}">
                    👏
                    @if ($update->likerscount() !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($update->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($update->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ $user->avatar }}" />
                    @endforeach
                    </span>
                    @endif
                </button>
            </span>
            @endif
            @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success me-1">
                    👏
                    @if ($update->likerscount() !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($update->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($update->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ $user->avatar }}" />
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
                    <span wire:target="deleteUpdate" wire:loading class="spinner-border spinner-border-mini ms-2" role="status"></span>
                </button>
                @else
                <button type="button" class="btn btn-task btn-outline-danger" wire:click="confirmDelete" wire:loading.attr="disabled" wire:offline.attr="disabled">
                    🗑
                </button>
                @endif
            @endif
            @endauth
        </div>
    </div>
</div>
