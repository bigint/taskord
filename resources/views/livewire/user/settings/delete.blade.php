<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5 text-danger">Danger Zone</span>
            <div class="fw-bold text-danger">
                Note: You can't recover your account
            </div>
        </div>
        <div class="card-body">
            <div class="h5 text-danger mb-3">Delete your Account</div>
            <div class="mb-3">
                Deleting your account is permanent. All your data will be wiped out immediately and you won't be able to get it back.
            </div>
            @if ($confirming === Auth::id())
            <button wire:click="deleteAccount" class="btn btn-danger">
                <x-heroicon-o-question-mark-circle class="heroicon" />
                Are you sure?
            </button>
            @else
            <button wire:click="confirmDelete" class="btn btn-danger">
                <x-heroicon-o-trash class="heroicon" />
                Delete now
            </button>
            @endif
        </div>
    </div>
</div>
