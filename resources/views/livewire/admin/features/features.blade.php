<div class="card">
    <div class="card-header h6 pt-3 pb-3 d-flex align-items-center justify-content-between">
        <div>
            <div class="h5">Features</div>
            Taskord Feature flags
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newFeatureModal">
                Create Feature flag
            </button>
        </div>
    </div>
    <div class="card-body">
        @foreach ($features as $feature)
            @livewire('admin.features.single-feature', [
                'feature' => $feature
            ], key($feature->id))
        @endforeach
    </div>
    @livewire('admin.features.create-feature')
</div>
