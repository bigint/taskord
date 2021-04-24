<div wire:ignore.self class="modal fade" id="editMilestoneModal" tabindex="-1" role="dialog" aria-labelledby="editMilestoneModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Milestone</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:target="submit" wire:submit.prevent="submit">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" value="{{ $name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Ask and discuss!" wire:model.defer="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="6" placeholder="What's on your mind?" wire:model.lazy="description">{{ $description }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="small fw-bold text-secondary mt-3 mb-3">
                            <x-heroicon-o-pencil-alt class="heroicon" />
                            Markdown is supported
                            <x-beta background="light" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Start Date</label>
                            <input class="form-control" wire:model="start_date" type="date" />
                        </div>
                        @if ($start_date)
                        <div class="mb-3">
                            <label class="form-label fw-bold">End Date</label>
                            <input class="form-control" wire:model="end_date" type="date" min="{{ carbon($start_date)->format('Y-m-d') }}" />
                        </div>
                        @else
                            <div class="fw-bold">Select from date to pick due date</div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
