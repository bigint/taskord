<div class="card mb-4">
    <div class="card-body">
        <div class="input-group">
            <button class="btn btn-outline-secondary trigger" wire:model="status_emoji" type="button">🍑</button>
            <input type="text" class="form-control" value="{{ $status }}" wire:model="status" placeholder="What's happening?">
        </div>
        <div class="d-flex justify-content-around pt-3">
            <button wire:click="resetStatus" class="btn btn-sm btn-danger text-white me-1 w-100">
                Clear Status
            </button>
            <button wire:click="setStatus" class="btn btn-sm btn-success text-white ms-1 w-100">
                Set Status
            </button>
        </div>
    </div>
</div>
