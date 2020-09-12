<div wire:ignore.self class="modal" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Member to the Team</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:target="submit" wire:submit.prevent="submit">
                <div class="modal-body">
                    @include('components.alert')
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Username</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="What's New?" wire:model.defer="title">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        Add Member
                        <span wire:target="submit" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
