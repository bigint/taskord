<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3">
            <span class="h5 text-danger">Danger Zone</span>
            <div class="fw-bold text-danger">
                Note: You can't recover your account
            </div>
        </div>
        <div class="card-body">
            <div class="h5 text-danger mb-3">Reset your Account</div>
            <div class="mb-3">
                Resetting your account is will be wiped out all your data immediately and you won't be able to get it
                back.
            </div>
            <button class="btn btn-outline-danger rounded-pill" data-bs-toggle="modal"
                data-bs-target="#resetAccountModal">
                <x-heroicon-o-trash class="heroicon" />
                Reset now
            </button>
            <div class="h5 text-danger mb-3 mt-4">Delete your Account</div>
            <div class="mb-3">
                Deleting your account is permanent. All your data will be wiped out immediately and you won't be able to
                get it back.
            </div>
            <button class="btn btn-outline-danger rounded-pill" data-bs-toggle="modal"
                data-bs-target="#deleteAccountModal">
                <x-heroicon-o-trash class="heroicon" />
                Delete now
            </button>
        </div>
    </div>
    <div class="modal fade" id="resetAccountModal" tabindex="-1" aria-labelledby="resetAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="resetAccountModalLabel">Reset Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to reset your account?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill"
                        data-bs-dismiss="modal">Cancel</button>
                    <button wire:loading.attr="disabled" wire:click="resetAccount" type="button"
                        class="btn btn-outline-danger rounded-pill">Reset Account</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteAccountModalLabel">Delete Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete your account?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill"
                        data-bs-dismiss="modal">Cancel</button>
                    <button wire:loading.attr="disabled" wire:click="deleteAccount" type="button"
                        class="btn btn-outline-danger rounded-pill">Delete Account</button>
                </div>
            </div>
        </div>
    </div>
</div>
