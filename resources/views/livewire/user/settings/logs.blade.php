<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3">
            <span class="h5">Security logs</span>
            <div>Recent events that happend on your account</div>
        </div>
        @if (count($activities) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-collection class="heroicon heroicon-60px text-primary mb-2" />
                <div class="h4">
                    Nothing has been logged!
                </div>
            </div>
        @endif
        <ul class="list-group list-group-flush">
            @foreach ($activities as $activity)
                <x-user-activity :activity="$activity" />
            @endforeach
        </ul>
        <div class="mt-3">
            {{ $activities->links() }}
            <div>
            </div>
        </div>
