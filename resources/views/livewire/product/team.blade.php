<div class="py-2 px-3">
    <a
        href="{{ route('user.done', ['username' => $user->username]) }}"
        class="user-hover"
        data-id="{{ $user->id }}"
    >
<<<<<<< HEAD
        <img loading=lazy class="rounded-circle avatar-30" src="{{ Helper::getCDNImage($user->avatar, 50) }}" alt="{{ $user->username }}'s avatar" />
=======
        <img loading=lazy class="rounded-circle avatar-30" src="{{ Helper::getCDNImage($user->avatar, 80) }}" alt="{{ $user->username }}'s avatar" />
>>>>>>> b18e0c01a7a50af04ce03ea488741e1ccafd70c7
    </a>
    <a
        href="{{ route('user.done', ['username' => $user->username]) }}"
        class="ms-2 align-middle fw-bold text-dark user-hover"
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
        <button class="btn btn-sm btn-danger float-end" wire:click="removeMember">
            <x-heroicon-o-x class="heroicon" />
            Remove
        </button>
    @endif
    @endauth
</div>
