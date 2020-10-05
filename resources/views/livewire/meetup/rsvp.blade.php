<div class="card-footer text-muted">
    @foreach($meetup->subscribers->take(5) as $user)
    <img class="avatar-20 rounded-circle" src="{{ $user->avatar }}" />
    @endforeach
    @auth
    @if (Auth::user()->hasSubscribed($meetup))
    <button class="btn btn-task btn-success text-white float-right font-weight-bold" wire:click="toggleRSVP">
        {{ Emoji::checkMarkButton() }} RSVPd
    </button>
    @else
    <button class="btn btn-task btn-outline-success text-dark float-right" wire:click="toggleRSVP">
        {{ Emoji::checkMarkButton() }} RSVP
    </button>
    @endif
    @else
    <a class="btn btn-task btn-outline-secondary text-dark float-right" href="{{ route('login') }}">
        {{ Emoji::checkMarkButton() }} RSVP
    </a>
    @endauth
</div>
