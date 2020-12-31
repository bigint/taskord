<div wire:init="loadStats">
    @if (!$readyToLoad)
    <div class="card-body text-center mt-3 mb-3">
        <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
        <div class="h6">
            Loading Stats...
        </div>
    </div>
    @endif
    WIP
</div>
