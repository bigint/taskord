<li class="nav-item mr-2">
    <a class="nav-link text-white" href="{{ route('notifications.unread') }}">
        {{ Emoji::bell() }}
        @auth
        @if (Auth::user()->unreadNotifications->count('id') !== 0)
        <span class="notification-count bg-danger font-weight-bold rounded">
            {{ Auth::user()->unreadNotifications->count('id') }}
        </span>
        @endif
        @endauth
    </a>
</li>
