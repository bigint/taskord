<li class="nav-item me-2">
    <a class="nav-link text-white" href="{{ route('notifications.unread') }}" aria-label="Notifications">
        <x-heroicon-o-bell class="heroicon-notification me-0" />
        @auth
        @if (Auth::user()->unreadNotifications->count('id') !== 0)
        <span class="notification-count bg-danger fw-bold rounded">
            {{ Auth::user()->unreadNotifications->count('id') }}
        </span>
        @endif
        @endauth
    </a>
</li>
