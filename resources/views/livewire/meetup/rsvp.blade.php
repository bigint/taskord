<div class="card-footer text-muted">
    <span class="avatar-stack ml-1">
        @foreach($meetup->subscribers->take(5) as $user)
        <img class="avatar-20 rounded-circle mr-1" src="{{ $user->avatar }}" />
        @endforeach
    </span>
    @if (Auth::user()->hasSubscribed($meetup))
    <button class="btn btn-sm btn-success text-white float-right font-weight-bold" wire:click="toggleRSVP">
        ✅ RSVPd
    </button>
    @else
    <button class="btn btn-sm btn-outline-secondary text-dark float-right" wire:click="toggleRSVP">
        ✅ RSVP
    </button>
    @endif
</div>
