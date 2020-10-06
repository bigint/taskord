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
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Bali Meetup" wire:model.defer="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" placeholder="Meetup Slug (/bali-meetup)" wire:model.defer="slug">
                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Tagline</label>
                        <input type="text" class="form-control @error('tagline') is-invalid @enderror" placeholder="Meetup about business" wire:model.defer="tagline">
                        @error('tagline')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Let's have a meet about business development" wire:model.defer="description"></textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Location</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" placeholder="Canggu, Bali" wire:model.defer="location">
                        @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Date in UTC</label>
                        <input class="form-control" wire:model.defer="date" type="datetime-local" value="{{ Carbon::now()->toDateTimeString() }}" min="{{ Carbon::now()->toDateTimeString() }}" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Cover</label>
                        <div class="form-file w-50">
                            <input type="file" wire:model="cover" class="form-file-input">
                            <label class="form-file-label">
                                <span class="form-file-text">Choose file...</span>
                                <span class="form-file-button">Browse</span>
                            </label>
                        </div>
                    </div>
                    <div wire:loading wire:target="cover">
                        <div class="spinner-border spinner-border-sm mb-3" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    @error('cover')
                    <div class="text-danger font-weight-bold mt-3">{{ $message }}</div>
                    @else
                    @if ($cover)
                    <div>
                        <img class="avatar-100 rounded mb-3" src="{{ $cover->temporaryUrl() }}">
                    </div>
                    @endif
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        Create Meetup
                        <span wire:target="submit" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
