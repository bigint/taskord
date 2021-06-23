<div class="mb-3">
    <a class="mb-2 btn btn-{{ Route::is('meetups.upcoming') ? '' : 'outline-' }}primary rounded-pill me-2"
        href="{{ route('meetups.upcoming') }}">
        Upcoming
    </a>
    <a class="mb-2 btn btn-{{ Route::is('meetups.finished') ? '' : 'outline-' }}primary rounded-pill me-2"
        href="{{ route('meetups.finished') }}">
        Finised
    </a>
    <a class="mb-2 btn btn-{{ Route::is('meetups.rsvpd') ? '' : 'outline-' }}primary rounded-pill me-2"
        href="{{ route('meetups.rsvpd') }}">
        RSVPd
    </a>
</div>
