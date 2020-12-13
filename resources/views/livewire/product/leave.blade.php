<div class="card mb-4">
    <div class="card-body">
        <button type="button" class="btn btn-block btn-danger text-white fw-bold" wire:click="leaveTeam">
            <i class="fa fa-sign-out mr-1"></i>
            Leave the Team
            <span wire:target="leaveTeam" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
        </button>
    </div>
</div>
