<div class="card-footer text-muted">
    <img class="avatar-20 rounded-circle" src="{{ $meetup->user->avatar }}" />
    @foreach($meetup->subscribers->take(5) as $user)
    <img class="avatar-20 rounded-circle" src="{{ $user->avatar }}" />
    @endforeach
    @auth
    @if (Auth::user()->hasSubscribed($meetup))
    <button class="btn btn-task btn-danger text-white float-end fw-bold" wire:click="toggleRSVP">
        {{ Emoji::crossMarkButton() }} Can't attend
    </button>
    @else
    <button class="btn btn-task btn-outline-success text-dark float-end" wire:click="toggleRSVP">
        {{ Emoji::checkMarkButton() }} RSVP
    </button>
    @endif
    @else
    <a class="btn btn-task btn-outline-secondary text-dark float-end" href="{{ route('login') }}">
        {{ Emoji::checkMarkButton() }} RSVP
    </a>
    @endauth
</div>
