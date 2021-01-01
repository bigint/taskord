<div class="card-header pt-3 pb-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <div class="h5">Meetups <x-staffship background="light" /></div>
            <div>Meet and greet.</div>
        </div>
        <div>
            <a href="{{ route('meetups.rsvpd') }}" class="btn btn-outline-success">
                RSVPd
            </a>
            <a href="{{ route('meetups.finished') }}" class="btn btn-outline-primary">
                Finished
            </a>
            @auth
                <button class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#newMeetupModal">
                    <x-heroicon-o-plus class="heroicon" />
                    New Meetup
                </button>
                @livewire('meetup.new-meetup')
            @endauth
        </div>
    </div>
</div>
