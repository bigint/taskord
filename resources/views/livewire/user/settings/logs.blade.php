<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Security logs</span>
            <div>Recent events that happend on your account</div>
        </div>
        <div class="card-body">
            @foreach ($activities as $activity)
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">{{ '@'.$user->username }} – {{ $activity->getExtraProperty('type') }}</h6>
                    <small class="text-secondary">{{ Carbon::parse($activity->created_at)->format('l, d M Y H:i:s') }} UTC</small>
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
