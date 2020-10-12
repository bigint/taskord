<div class="d-flex p-3">
    <img class="avatar-50 rounded-circle mr-3" src="{{ $user->avatar }}" />
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
        <div class="mt-2 text-dark">
            <i class="fa fa-compass mr-1 text-black-50"></i>
            {{ $user->location }}
        </div>
        @endif
    </div>
</div>
<hr class="mt-0 mb-0">
<div class="p-3">
    <div>
        <i class="fa fa-check-square mr-1 text-black-50"></i>
        <span class="text-dark">{{ $user->tasks()->whereDone(true)->count() }} Completed Tasks<span>
    </div>
    <div class="mt-1">
        <i class="fa fa-hourglass-start mr-1 text-black-50"></i>
        <span class="text-dark">{{ $user->tasks()->whereDone(false)->count() }} Pending Tasks<span>
    </div>
</div>
