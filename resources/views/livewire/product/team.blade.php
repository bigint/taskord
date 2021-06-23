<div class="py-2 px-3">
    <a href="{{ route('user.done', ['username' => $user->username]) }}" class="user-popover"
        data-id="{{ $user->id }}">
        <img loading=lazy class="rounded-circle avatar-30" src="{{ Helper::getCDNImage($user->avatar, 80) }}"
            height="30" width="30" alt="{{ $user->username }}'s avatar" />
    </a>
    <a href="{{ route('user.done', ['username' => $user->username]) }}"
        class="ms-2 align-middle fw-bold text-dark user-popover" data-id="{{ $user->id }}">
        @if ($user->firstname or $user->lastname)
            {{ $user->firstname }}{{ ' ' . $user->lastname }}
        @else
            {{ $user->username }}
        @endif
        @if ($user->status)
            <span class="ms-1 small" title="{{ $user->status }}">{{ $user->status_emoji }}</span>
        @endif
    </a>
    @auth
        @if ($product->user->id === auth()->user()->id)
            <button class="btn btn-sm btn-outline-danger rounded-pill float-end" wire:click="removeMember"
                wire:loading.attr="disabled">
                <x-heroicon-o-x class="heroicon heroicon-15px" />
                Remove
            </button>
        @endif
    @endauth
</div>
