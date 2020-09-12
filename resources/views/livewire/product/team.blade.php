<li class="list-group-item pt-2 pb-2">
    <a href="{{ route('user.done', ['username' => $user->username]) }}">
        <img class="rounded-circle avatar-30" src="{{ $user->avatar }}" />
    </a>
    <a href="{{ route('user.done', ['username' => $user->username]) }}" class="ml-2 align-middle font-weight-bold text-dark">
        @if ($user->firstname or $user->lastname)
            {{ $user->firstname }}{{ ' '.$user->lastname }}
        @else
            {{ $user->username }}
        @endif
    </a>
    @auth
    @if ($product->owner->id === Auth::id())
        <button class="btn btn-sm btn-danger float-right" wire:click="removeMember">
            <i class="fa fa-times mr-1"></i>
            Remove
        </button>
    @endif
    @if ($product->members->contains(Auth::id()))
        <button class="btn btn-sm btn-danger float-right" wire:click="removeMember">
            <i class="fa fa-sign-out mr-1"></i>
            Leave
        </button>
    @endif
    @endauth
</li>
