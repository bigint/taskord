<div wire:ignore.self class="modal fade" id="newMeetupModal" tabindex="-1" role="dialog" aria-labelledby="newMeetupModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Meetup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:target="submit" wire:submit.prevent="submit">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Bali Meetup" wire:model.defer="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" placeholder="Meetup Slug (/bali-meetup)" wire:model.defer="slug">
                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tagline</label>
                        <input type="text" class="form-control @error('tagline') is-invalid @enderror" placeholder="Meetup about business" wire:model.defer="tagline">
                        @error('tagline')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Let's have a meet about business development" wire:model.defer="description"></textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Location</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" placeholder="Canggu, Bali" wire:model.defer="location">
                        @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Date in UTC</label>
                        <input class="form-control" wire:model.defer="date" type="datetime-local" value="{{ carbon()->toDateTimeString() }}" min="{{ carbon()->toDateTimeString() }}" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cover (1500x500)</label>
                        <div class="form-file w-50">
                            <input class="form-control form-control-sm" wire:model="cover" type="file">
                        </div>
                    </div>
                    <div wire:loading wire:target="cover">
                        <div class="spinner-border spinner-border-sm mb-3" role="status"></div>
                    </div>
                    @error('cover')
                        <div class="text-danger fw-bold mt-3">{{ $message }}</div>
                    @else
                        @if ($cover)
                            <div>
                                <img loading=lazy class="avatar-100 rounded mb-3" src="{{ $cover->temporaryUrl() }}" height="100" width="100" />
                            </div>
                        @endif
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary rounded-pill">
                        Create Meetup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
