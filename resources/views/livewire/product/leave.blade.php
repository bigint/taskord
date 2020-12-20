<div class="card mb-4">
    <div class="card-body">
        <button type="button" class="btn w-100 btn-danger text-white fw-bold" wire:click="leaveTeam">
            <x-heroicon-o-logout class="heroicon" />
            Leave the Team
            <span wire:target="leaveTeam" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
        </button>
    </div>
</div>
