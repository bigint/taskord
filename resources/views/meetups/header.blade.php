<div class="card-header py-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <div class="h5">Meetups
                <x:labels.staff-ship />
            </div>
            <div>Meet and greet.</div>
        </div>
        <div>
            <a href="{{ route('meetups.rsvpd') }}" class="btn btn-outline-success rounded-pill">
                RSVPd
            </a>
            <a href="{{ route('meetups.finished') }}" class="btn btn-outline-primary rounded-pill">
                Finished
            </a>
            @auth
                <button class="btn btn-outline-success rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#newMeetupModal">
                    <x-heroicon-o-plus class="heroicon" />
                    New Meetup
                </button>
                <livewire:meetups.new-meetup />
            @endauth
        </div>
    </div>
</div>
