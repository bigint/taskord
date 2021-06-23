<div wire:ignore.self class="modal fade" id="newUpdateModal" tabindex="-1" role="dialog"
    aria-labelledby="newUpdateModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:target="submit" wire:submit.prevent="submit">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                            placeholder="What's New?" wire:model.defer="title">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Body</label>
                        <textarea class="form-control @error('body') is-invalid @enderror" rows="6"
                            placeholder="What's new on {{ $product->name }}?" wire:model.defer="body"></textarea>
                        @error('body')
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
                        Post Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
