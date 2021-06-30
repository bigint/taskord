<div wire:init="loadBadges">
    @if (!$readyToLoad)
        Loading
    @else
        @if (count($badges) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-tag class="heroicon heroicon-60px text-primary mb-2" />
                <div class="h4">
                    No badges asked
                </div>
            </div>
        @endif
        @foreach ($badges as $badge)
            @livewire('badges.single-badge', [
            'badge' => $badge,
            ], key($badge->id))
        @endforeach
        @if ($badges->hasMorePages())
            <livewire:badges.load-more :page="$page" :perPage="$perPage" />
        @endif
    @endif
</div>
