<div wire:ignore.self class="modal fade" id="newQuestionModal" tabindex="-1" role="dialog"
    aria-labelledby="newQuestionModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Deal</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:target="submit" wire:submit.prevent="submit">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Product Name" wire:model.defer="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="6"
                            placeholder="About the product" wire:model.defer="description"></textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Offer %</label>
                        <input type="text" class="form-control @error('offer') is-invalid @enderror"
                            placeholder="Offer in %" wire:model.defer="offer">
                        @error('offer')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Coupon code</label>
                        <input type="text" class="form-control @error('coupon') is-invalid @enderror"
                            placeholder="Coupon code" wire:model.defer="coupon">
                        @error('coupon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Referral URL</label>
                        <input type="text" class="form-control @error('referral') is-invalid @enderror"
                            placeholder="Referral URL" wire:model.defer="referral">
                        @error('referral')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Website URL</label>
                        <input type="text" class="form-control @error('website') is-invalid @enderror"
                            placeholder="Website URL" wire:model.defer="website">
                        @error('website')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Logo URL</label>
                        <input type="text" class="form-control @error('logo') is-invalid @enderror"
                            placeholder="Logo URL" wire:model.defer="logo">
                        @error('logo')
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
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
