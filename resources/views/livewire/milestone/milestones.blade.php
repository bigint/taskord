<div wire:init="loadMilestones">
    @if (!$ready_to_load)
        <div class="card-body text-center mt-3 mb-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading milestones...
            </div>
        </div>
    @endif
    @if ($ready_to_load and count($milestones) === 0)
        <div class="card-body text-center mt-3 mb-3">
            <x-heroicon-o-truck class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                No milestones found
            </div>
        </div>
    @endif
    @foreach ($milestones as $milestone)
        <livewire:milestone.single-milestone :type="$type" :milestone="$milestone" :wire:key="$milestone->id" />
    @endforeach
    @if ($ready_to_load and $milestones->hasMorePages())
        <livewire:milestone.load-more :type="$type" :page="$page" :perPage="$perPage" />
    @endif
</div>
