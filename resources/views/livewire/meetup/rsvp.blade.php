<div class="card-footer text-muted">
    <img loading=lazy class="avatar-20 rounded-circle" src="{{ Helper::getCDNImage($meetup->user->avatar, 80) }}" height="20" width="20" alt="{{ $meetup->user->username }}'s avatar" />
    @foreach($meetup->subscribers->take(5) as $user)
        <img loading=lazy class="avatar-20 rounded-circle" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="20" width="20" alt="{{ $user->username }}'s avatar" />
    @endforeach
    @auth
        @if (auth()->user()->hasSubscribed($meetup))
            <button class="btn btn-action btn-danger text-white float-end fw-bold" wire:click="toggleRSVP" wire:loading.attr="disabled" aria-label="Can't Attend">
                ❌ Can't attend
            </button>
        @else
            <button class="btn btn-action btn-outline-success text-dark float-end" wire:click="toggleRSVP" wire:loading.attr="disabled" aria-label="RSVP">
                ✅ RSVP
            </button>
        @endif
    @else
        <a class="btn btn-action btn-outline-secondary text-dark float-end" href="{{ route('login') }}" aria-label="RSVP">
            ✅ RSVP
        </a>
    @endauth
</div>
