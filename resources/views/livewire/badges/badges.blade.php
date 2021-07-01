<div wire:init="loadBadges">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="d-flex align-items-center mb-0">
            <span class="me-2">Explore Badges</span>
            <x:labels.beta />
        </h5>
        <input wire:model="query" type="text" class="form-control ms-2 w-25" placeholder="Search badges...">
    </div>
    @if (!$readyToLoad)
        <div>
            <x:loaders.badge-skeleton count="1" />
        </div>
        <div class="mt-2">
            <x:loaders.badge-skeleton count="1" />
        </div>
        <div class="mt-2">
            <x:loaders.badge-skeleton count="1" />
        </div>
    @else
        @if (count($badges) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-tag class="heroicon heroicon-60px text-primary mb-2" />
                <div class="h4">
                    No badges found
                </div>
            </div>
        @endif
        @foreach ($badges as $badge)
            @livewire('badges.single-badge', [
            'badge' => $badge,
            ], key($badge->id))
        @endforeach
        {{ $badges->links() }}
    @endif
</div>
