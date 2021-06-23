<div class="card mb-3">
    <div class="card-body d-flex align-items-center justify-content-between">
        <div>
            <h3>{{ $feature->name }}</h3>
            <code>{{ $feature->slug }}</code>
            <div class="mt-2">{{ $feature->description }}</div>
            @if ($confirming === $feature->id)
                <button role="button" class="btn btn-action btn-danger mt-2" wire:click="deleteFeature"
                    wire:loading.attr="disabled" aria-label="Confirm Delete">
                    Are you sure?
                </button>
            @else
                <button role="button" class="btn btn-action btn-outline-danger mt-2" wire:click="confirmDelete"
                    wire:loading.attr="disabled" aria-label="Delete feature">
                    <x-heroicon-o-trash class="heroicon heroicon-15px" />
                    Delete feature
                </button>
            @endif
            @if ($confirming === $feature->id)
                <div class="mt-2">
                    Make sure you have deleted <code>feature('{{ $feature->slug }}')</code> in the codebase
                </div>
            @endif
        </div>
        <div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="staffCheckBox" wire:click="staffToggle"
                    wire:model="staffStatus">
                <label class="form-check-label" for="staffCheckBox">Enable for <b>staff</b></label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="contributorCheckBox" wire:click="contributorToggle"
                    wire:model="contributorStatus">
                <label class="form-check-label" for="contributorCheckBox">Enable for <b>contributors</b></label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="betaCheckBox" wire:click="betaToggle"
                    wire:model="betaStatus">
                <label class="form-check-label" for="betaCheckBox">Enable for <b>beta</b></label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="publicCheckBox" wire:click="publicToggle"
                    wire:model="publicStatus">
                <label class="form-check-label" for="publicCheckBox">Enable for <b>public</b></label>
            </div>
        </div>
    </div>
</div>
