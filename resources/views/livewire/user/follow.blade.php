<div>
    @auth
    @if (Auth::id() !== $user->id && !$user->isFlagged)
    @if (user()->isFollowing($user))
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-danger mb-2">
        <x-heroicon-o-user-remove class="heroicon" />
        Unfollow
    </button>
    @else
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-primary mb-2">
        <x-heroicon-o-user-add class="heroicon" />
        Follow
    </button>
    @endif
    @endif
    @endauth
    <div class="small">
        <a class="text-dark" href="{{ route('user.following', ['username' => $user->username]) }}">
            <span class="fw-bold">{{ $user->followings()->count('id') }}</span>
            {{ str_plural('Following', $user->followings()->count('id')) }}
        </a>
        <a class="text-dark" href="{{ route('user.followers', ['username' => $user->username]) }}">
            <span class="fw-bold ms-2">{{ number_format($user->followers()->count()) }}</span>
            {{ str_plural('Follower', $user->followers()->count('id')) }}
        </a>
        @php
            $likes = $user->likes(App\Models\Task::class)->count('id') +
                $user->likes(App\Models\Comment::class)->count('id') +
                $user->likes(App\Models\Question::class)->count('id') +
                $user->likes(App\Models\Answer::class)->count('id')
        @endphp
        <span class="fw-bold ms-2">
            {{
                number_format(
                    $likes
                )
            }}
        </span>
        {{ str_plural('Praise', $likes) }}
    </div>
</div>
