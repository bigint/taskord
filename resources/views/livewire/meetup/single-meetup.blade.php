<div class="col-6 col-md-4 col-lg-3 mb-4">
    <div class="card mx-auto">
        <a href="#url"><img class="card-img-top" src="{{ $meetup->cover }}" alt="Sample Title"></a>
        <div class="card-body">
            <div class="font-weight-bold text-uppercase small">
                {{ Carbon::parse($meetup->starts_at)->format('D, M d, H:i') }}
                @if (Carbon::parse($meetup->starts_at)->isToday())
                <span class="text-black-50">(Happening)</span>
                @endif
            </div>
            <h5 class="card-title mt-2">
                <a href="#url">{{ $meetup->name }}</a>
            </h5>
            <div>
                {{ $meetup->tagline }}
            </div>
        </div>
        @auth
        @livewire('meetup.rsvp', ['meetup' => $meetup])
        @endauth
    </div>
</div>
