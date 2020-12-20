<div>
    @if ($notifications->count('id') === 0)
    <div class="card-body text-center mt-5">
        <x-heroicon-o-bell class="heroicon-4x text-primary mb-2" />
        <div class="h4">
            No notifications
        </div>
    </div>
    @endif
    @foreach ($notifications as $notification)
        <div>
            @livewire('notification.single-notification', [
                'type' => $notification->type,
                'data' => $notification->data,
                'created_at' => $notification->created_at,
            ], key($notification->id))
        </div>
    @endforeach
    @if ($notifications->hasMorePages())
        @livewire('notification.load-more', [
            'type' => 'all',
            'page' => $page,
            'perPage' => $perPage
        ])
    @endif
</div>
