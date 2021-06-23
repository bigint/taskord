<div wire:ignore.self class="modal fade" id="newFeatureModal" tabindex="-1" role="dialog"
    aria-labelledby="newFeatureModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Feature flag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:target="submit" wire:submit.prevent="submit">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Name of the feature" wire:model.defer="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                            placeholder="Slug of the feature" wire:model.defer="slug">
                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror mentionInput" rows="6"
                            placeholder="What does this feature do?" wire:model.defer="description"></textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary rounded-pill">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
