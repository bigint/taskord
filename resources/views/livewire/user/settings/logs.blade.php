<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Security logs</span>
            <div>Recent events that happend on your account</div>
        </div>
        <div class="card-body">
            @if (count($activities) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-collection class="heroicon-4x text-primary mb-2" />
                <div class="h4">
                    Nothing has been logged!
                </div>
            </div>
            @endif
            @foreach ($activities as $activity)
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">
                        {{ '@'.$user->username }} –
                        @if ($activity->getExtraProperty('type') === 'Admin')
                            Admin 🛡
                        @endif
                        @if ($activity->getExtraProperty('type') === 'Auth')
                            Auth 🚪
                        @endif
                        @if ($activity->getExtraProperty('type') === 'Task')
                            Task ✅
                        @endif
                        @if ($activity->getExtraProperty('type') === 'Answer')
                            Answer 💬
                        @endif
                        @if ($activity->getExtraProperty('type') === 'Comment')
                            Comment 💬
                        @endif
                        @if ($activity->getExtraProperty('type') === 'Question')
                            Question ❓
                        @endif
                        @if ($activity->getExtraProperty('type') === 'User')
                            User 👤
                        @endif
                        @if ($activity->getExtraProperty('type') === 'Product')
                            Product 📦
                        @endif
                        @if ($activity->getExtraProperty('type') === 'Notification')
                            Notification 🔔
                        @endif
                        @if ($activity->getExtraProperty('type') === 'Search')
                            Search 🔍
                        @endif
                        @if ($activity->getExtraProperty('type') === 'Throttle')
                            Throttled 🛑
                        @endif
                    </h6>
                    <small class="text-secondary">{{ Carbon::parse($activity->created_at)->diffForHumans() }}</small>
                </div>
                <p class="mb-1">
                    {{ $activity->description }}
                </p>
                @if (! $loop->last)
                <hr/>
                @endif
            @endforeach
            <div class="mt-4">
                {{ $activities->links() }}
            <div>
        </div>
    </div>
</div>
