<div wire:ignore.self class="modal fade" id="addMemberModal" tabindex="-1" role="dialog"
    aria-labelledby="addMemberModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Member to the Team</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:target="submit" wire:submit.prevent="submit">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" class="form-control" placeholder="Enter the username"
                            wire:model.defer="username">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary rounded-pill">
                        Add Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
