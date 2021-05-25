<div wire:init="loadUnreadNotifications">
    @if (!$ready_to_load)
        <div class="card-body text-center mt-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading notifications...
            </div>
        </div>
    @endif
    @if ($ready_to_load and count($notifications) === 0)
        <div class="card-body text-center mt-5">
            <x-heroicon-o-bell class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                Inbox zero
            </div>
            <p class="text-secondary">
                Congratulations, you have read all your notifications.
            </p>
        </div>
    @endif
    @foreach ($notifications as $notification)
        <div>
            @livewire('notification.single-notification', [
                'notification_id' => $notification->id,
                'type' => $notification->type,
                'data' => $notification->data,
                'created_at' => $notification->created_at,
                'page_type' => 'unread',
            ], key($notification->id))
        </div>
    @endforeach
    @if ($ready_to_load and $notifications->hasMorePages())
        <livewire:notification.load-more type="unread" :page="$page" :perPage="$perPage" />
    @endif
</div>
