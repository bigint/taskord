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
    @if ($product->owner->id === Auth::id())
        <button wire:click="removeMember">Remove</button>
    @endif
</li>
