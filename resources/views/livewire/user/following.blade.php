<div>
    @if (count($user->followings) === 0)
    <div class="card-body text-center">
        <i class="fa fa-3x fa-users mb-3 text-primary"></i>
        <div class="h5">
            Not following anyone!
        </div>
    </div>
    @endif
    @foreach ($user->followings as $user)
    <div class="card mb-3">
        <div class="card-body d-flex align-items-center">
        <img class="rounded-circle avatar-40 mt-1" src="{{ $user->avatar }}" />
            <span class="ml-3">
                <a href="{{ route('user.done', ['username' => $user->username]) }}" class="align-text-top text-dark">
                    <span class="font-weight-bold">
                        @if ($user->firstname or $user->lastname)
                            {{ $user->firstname }}{{ ' '.$user->lastname }}
                        @else
                            {{ $user->username }}
                        @endif
                    </span>
                    <div class="mb-2">{{ $user->bio }}</div>
                </a>
                @if (Auth::check() && Auth::id() !== $user->id && !$user->isFlagged)
                    @livewire('user.follow', [
                        'user' => $user
                    ])
                @endif
            </span>
        </div>
    </div>
    @endforeach
</div>
