<div class="card" wire:init="loadActivities" wire:poll>
    <div class="card-header h6 py-3">
        <div class="h5">Activities</div>
        <span class="fw-bold">{{ $ready_to_load ? $count : '···' }}</span>
        total activities
    </div>
    <div class="table-responsive">
        @if (!$ready_to_load)
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
    {{ $ready_to_load ? $activities->links() : '' }}
</div>
