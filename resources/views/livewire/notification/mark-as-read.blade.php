<button class="btn btn-success text-white float-md-right mb-3" wire:click="markAsRead">
    <i class="fa fa-check mr-1"></i>
    Mark all as Read
    <span wire:target="markAsRead" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
</button>
