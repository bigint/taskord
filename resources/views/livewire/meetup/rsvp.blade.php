<div class="card-footer text-muted">
    <img loading=lazy class="avatar-20 rounded-circle" src="{{ Helper::getCDNImage($meetup->user->avatar) }}" alt="{{ $meetup->user->username }}'s avatar" />
    @foreach($meetup->subscribers->take(5) as $user)
    <img loading=lazy class="avatar-20 rounded-circle" src="{{ Helper::getCDNImage($user->avatar) }}" alt="{{ $user->username }}'s avatar" />
    @endforeach
    @auth
    @if (Auth::user()->hasSubscribed($meetup))
    <button class="btn btn-task btn-danger text-white float-end fw-bold" wire:click="toggleRSVP">
        ❌ Can't attend
    </button>
    @else
    <button class="btn btn-task btn-outline-success text-dark float-end" wire:click="toggleRSVP">
        ✅ RSVP
    </button>
    @endif
    @else
    <a class="btn btn-task btn-outline-secondary text-dark float-end" href="{{ route('login') }}">
        ✅ RSVP
    </a>
    @endauth
</div>
