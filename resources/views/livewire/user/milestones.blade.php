<div wire:init="loadMilestones">
    @if (!$readyToLoad)
        <div class="card-body text-center mt-3 mb-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading milestones...
            </div>
        </div>
    @endif
    @if ($readyToLoad and count($milestones) === 0)
        <div class="card-body text-center mt-3 mb-3">
            <x-heroicon-o-chat-alt-2 class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                No milestones made
            </div>
        </div>
    @endif
    @foreach ($milestones as $milestone)
        <livewire:milestone.single-milestone type="milestones.opened" :milestone="$milestone"
            :wire:key="$milestone->id" />
    @endforeach

    {{ $readyToLoad ? $milestones->links() : '' }}
</div>
