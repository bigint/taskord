<div class="card mb-3">
    <div class="card-body d-flex align-items-center justify-content-between">
        <div>
            <h3>{{ $feature->name }}</h3>
            <code>{{ $feature->slug }}</code>
            <div class="mt-2">{{ $feature->description }}</div>
        </div>
        <div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="staffCheckBox" wire:click="staffToggle" wire:model="staffStatus">
                <label class="form-check-label" for="staffCheckBox">Promote to <b>staff</b></label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="betaCheckBox" wire:click="betaToggle" wire:model="betaStatus">
                <label class="form-check-label" for="betaCheckBox">Promote to <b>beta</b></label>
            </div>
        </div>
    </div>
</div>
