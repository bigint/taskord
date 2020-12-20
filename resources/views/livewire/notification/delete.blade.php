<button class="btn btn-danger float-md-end mb-3" wire:click="deleteAll">
    <x-heroicon-o-trash class="heroicon" />
    Delete all Notification
    <span wire:target="deleteAll" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
</button>
