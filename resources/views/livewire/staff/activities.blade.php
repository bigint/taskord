<div class="card" wire:init="loadActivities" wire:poll>
    <div class="card-header h6 py-3">
        <div class="h5">Activities</div>
        <span class="fw-bold">{{ $readyToLoad ? $count : '···' }}</span>
        total activities
    </div>
    <div class="table-responsive">
        @if (!$readyToLoad)
            <div class="card-body text-center mt-3">
                <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                <div class="h6">
                    Loading activities...
                </div>
            </div>
        @else
            <ul class="list-group list-group-flush">
                @foreach ($activities as $activity)
                    <x-user-activity :activity="$activity" />
                @endforeach
            </ul>
        @endif
    </div>
    {{ $readyToLoad ? $activities->links() : '' }}
</div>
