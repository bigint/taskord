<div>
    @if (count($user->followers) === 0)
    <x-empty icon="users" text="{{ $user->username }} doesn’t have any followers yet." />
    @endif
    @foreach ($user->followers as $user)
    <div class="card mb-3">
        <div class="card-body d-flex align-items-center">
        <img class="rounded-circle avatar-40 mt-1" src="{{ Helper::getCDNImage($user->avatar) }}" alt="{{ $user->username }}'s avatar" />
            <span class="ms-3">
                <a href="{{ route('user.done', ['username' => $user->username]) }}" class="align-text-top text-dark">
                    <span class="fw-bold">
                        @if ($user->firstname or $user->lastname)
                            {{ $user->firstname }}{{ ' '.$user->lastname }}
                        @else
                            {{ $user->username }}
                        @endif
                    </span>
                    <div class="mb-2">{{ $user->bio }}</div>
                </a>
                @auth
                @if (Auth::id() !== $user->id && !$user->isFlagged)
                    @livewire('user.follow', [
                        'user' => $user
                    ])
                @endif
                @endauth
            </span>
        </div>
    </div>
    @endforeach
</div>
