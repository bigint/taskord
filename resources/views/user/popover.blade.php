<h3 class="popover-header small">
    {{ Emoji::fire() }} {{ number_format($user->getPoints()) }} {{ $user->getPoints(true) < 2 ? 'Reputation' : 'Reputations' }}
</h3>
<div class="d-flex pr-3 pl-3 pt-3 pb-2">
    <img class="avatar-40 rounded-circle mr-2" src="{{ $user->avatar }}" />
    <div>
        <div class="font-weight-bold text-dark">
            @if ($user->firstname or $user->lastname)
                {{ $user->firstname }}{{ ' '.$user->lastname }}
            @else
                {{ $user->username }}
            @endif
            @if ($user->isVerified)
                <i class="fa fa-check-circle ml-1 text-primary" data-toggle="tooltip" data-placement="right" title="Verified"></i>
            @endif
            @if ($user->isPatron)
                <a class="ml-1 small" href="{{ route('patron.home') }}" data-toggle="tooltip" data-placement="right" title="Patron">
                    {{ Emoji::handshake() }}
                </a>
            @endif
        </div>
        <div class="small text-dark">{{ '@'.$user->username }}</div>
        @if ($user->bio)
        <div class="mt-2 text-dark">{{ $user->bio }}</div>
        @endif
        @if ($user->location)
        <div class="mt-1 text-dark">
            <i class="fa fa-compass mr-1 text-black-50"></i>
            {{ $user->location }}
        </div>
        @endif
    </div>
</div>
<hr class="mt-0 mb-0">
<div class="pt-2 pb-2 pl-3 pr-3">
    <div class="text-dark">
        <div>
            <i class="fa fa-check mr-1 text-black-50"></i>
            <span>{{ $user->tasks()->whereDone(true)->count() }} Completed Tasks<span>
        </div>
        <div class="mt-1">
            <i class="fa fa-hourglass-start mr-1 text-black-50"></i>
            <span>{{ $user->tasks()->whereDone(false)->count() }} Pending Tasks<span>
        </div>
    </div>
</div>
