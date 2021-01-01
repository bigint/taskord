<div class="py-2 px-3">
    <a
        href="{{ route('user.done', ['username' => $user->username]) }}"
        class="user-popover"
        data-id="{{ $user->id }}"
    >
        <img loading=lazy class="rounded-circle avatar-30" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="30" width="30" alt="{{ $user->username }}'s avatar" />
    </a>
    <a
        href="{{ route('user.done', ['username' => $user->username]) }}"
        class="ms-2 align-middle fw-bold text-dark user-popover"
        data-id="{{ $user->id }}"
    >
        @if ($user->firstname or $user->lastname)
            {{ $user->firstname }}{{ ' '.$user->lastname }}
        @else
            {{ $user->username }}
        @endif
    </a>
    @auth
    @if ($product->owner->id === user()->id)
        <button class="btn btn-sm btn-danger float-end" wire:click="removeMember" wire:loading.attr="disabled">
            <x-heroicon-o-x class="heroicon" />
            Remove
        </button>
    @endif
    @endauth
</div>
