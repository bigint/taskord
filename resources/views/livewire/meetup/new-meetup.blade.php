<div wire:ignore.self class="modal" id="newMeetupModal" tabindex="-1" role="dialog" aria-labelledby="newMeetupModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Meetup</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:target="submit" wire:submit.prevent="submit">
                <div class="modal-body">
                    <x-alert />
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Simply the name of the product" wire:model.defer="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" placeholder="Product Slug (/taskord)" wire:model.defer="slug">
                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Tagline</label>
                        <input type="text" class="form-control @error('tagline') is-invalid @enderror" placeholder="Simply the name of the product" wire:model.defer="tagline">
                        @error('tagline')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Some words about your awesome product" wire:model.defer="description"></textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Date in UTC</label>
                        <input class="form-control" wire:model.defer="date" type="datetime-local" min="{{ Carbon::today()->format('Y-m-d') }}" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        Create Product
                        <span wire:target="submit" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
