<div class="card-footer text-muted">
    @if (Auth::user()->hasSubscribed($meetup))
    <button class="btn btn-sm btn-success text-white float-right font-weight-bold" wire:click="rsvp">
        ✅ RSVPd
    </button>
    @else
    <button class="btn btn-sm btn-outline-secondary text-dark float-right" wire:click="rsvp">
        ✅ RSVP
    </button>
    @endif
</div>
