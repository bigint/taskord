<div class="card-footer text-muted">
    @foreach($meetup->subscribers->take(5) as $user)
    <img class="avatar-20 rounded-circle" src="{{ $user->avatar }}" />
    @endforeach
    @auth
    @if (Auth::user()->hasSubscribed($meetup))
    <button class="btn btn-sm btn-success text-white float-right font-weight-bold" wire:click="toggleRSVP">
        ✅ RSVPd
    </button>
    @else
    <button class="btn btn-sm btn-outline-secondary text-dark float-right" wire:click="toggleRSVP">
        ✅ RSVP
    </button>
    @endif
    @else
    <a class="btn btn-sm btn-outline-secondary text-dark float-right" href="{{ route('login') }}">
        ✅ RSVP
    </a>
    @endauth
</div>
