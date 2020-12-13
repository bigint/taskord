<button class="btn btn-success text-white float-md-end mb-3" wire:click="markAsRead">
    <i class="fa fa-check me-1"></i>
    Mark all as Read
    <span wire:target="markAsRead" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
</button>
