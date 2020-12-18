<div class="py-2 px-3">
    <a
        href="{{ route('user.done', ['username' => $user->username]) }}"
        class="user-hover"
        data-id="{{ $user->id }}"
    >
        <img class="rounded-circle avatar-30" src="{{ $user->avatar }}" alt="{{ $user->username }}'s avatar" />
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
            <i class="fa fa-times me-1"></i>
            Remove
        </button>
    @endif
    @endauth
</div>
