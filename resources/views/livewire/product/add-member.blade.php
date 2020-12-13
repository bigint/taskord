<div wire:ignore.self class="modal" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Member to the Team</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:target="submit" wire:submit.prevent="submit">
                <div class="modal-body">
                    <x-alert />
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" class="form-control @if (session()->has('team-error')) is-invalid @endif" placeholder="Enter the username" wire:model.defer="username">
                        @if (session()->has('team-error'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ session('team-error') }}</strong>
                            </span>
                        @endif
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
