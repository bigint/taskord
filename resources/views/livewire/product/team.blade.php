<li class="list-group-item pt-2 pb-2">
    <a
        href="{{ route('user.done', ['username' => $user->username]) }}"
        id="user-hover"
        data-id="{{ $user->id }}"
    >
        <img class="rounded-circle avatar-30" src="{{ $user->avatar }}" />
    </a>
    <a
        href="{{ route('user.done', ['username' => $user->username]) }}"
        class="ml-2 align-middle fw-bold text-dark"
        id="user-hover"
        data-id="{{ $user->id }}"
    >
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
    @endauth
</li>
