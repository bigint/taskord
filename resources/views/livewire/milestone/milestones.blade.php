<div wire:init="loadMilestones">
    @if (!$readyToLoad)
    <div class="card-body text-center mt-3 mb-3">
        <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
        <div class="h6">
            Loading Milestones...
        </div>
    </div>
    @endif
    @if ($readyToLoad and count($milestones) === 0)
    <div class="card-body text-center mt-3 mb-3">
        <x-heroicon-o-question-mark-circle class="heroicon-4x text-primary mb-2" />
        <div class="h4">
            No milestones asked
        </div>
    </div>
    @endif
    @foreach ($milestones as $milestone)
        @livewire('milestone.single-milestone', [
            'type' => $type,
            'milestone' => $milestone,
        ], key($milestone->id))
    @endforeach
    @if ($readyToLoad and $milestones->hasMorePages())
        @livewire('milestone.load-more', [
            'type' => $type,
            'page' => $page,
            'perPage' => $perPage
        ])
    @endif
</div>
