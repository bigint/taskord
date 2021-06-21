<div wire:init="loadMeetups">
    @if (!$readyToLoad)
        <div class="card-body text-center mt-3 mb-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading meetups...
            </div>
        </div>
    @endif
    @if ($readyToLoad and count($meetups) === 0)
        <div class="card-body text-center mt-3 mb-3">
            <x-heroicon-o-truck class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                No meetups found
            </div>
        </div>
    @endif
    @foreach ($meetups as $meetup)
        <livewire:meetups.single-meetup :type="$type" :meetup="$meetup" :wire:key="$meetup->id" />
    @endforeach
    @if ($readyToLoad and $meetups->hasMorePages())
        <livewire:meetups.load-more :type="$type" :page="$page" :perPage="$perPage" />
    @endif
</div>
