<div class="card" wire:init="loadFeatures">
    <div class="card-header h6 py-3 d-flex align-items-center justify-content-between">
        <div>
            <div class="h5">Features</div>
            Taskord Feature flags
        </div>
        <div>
            <button type="button" class="btn btn-outline-primary rounded-pill" data-bs-toggle="modal"
                data-bs-target="#newFeatureModal">
                Create Feature flag
            </button>
        </div>
    </div>
    <div class="card-body">
        @if (!$readyToLoad)
            <div class="card-body text-center mt-3">
                <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                <div class="h6">
                    Loading features...
                </div>
            </div>
        @else
            @foreach ($features as $feature)
                <livewire:staff.features.single-feature :feature="$feature" :wire:key="$feature->id" />
            @endforeach
        @endif
    </div>
    <livewire:staff.features.create-feature />
</div>
