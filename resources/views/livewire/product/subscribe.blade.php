<div>
    @if (Auth::user()->hasLiked($product))
    <button wire:click="subscribeProduct" wire:loading.attr="disabled" class="btn btn-sm btn-danger mb-2">
        <i class="fa fa-minus mr-1"></i>
        Unsubscribe
        <span wire:target="subscribeProduct" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
    </button>
    @else
    <button wire:click="subscribeProduct" wire:loading.attr="disabled" class="btn btn-sm btn-primary mb-2">
        <i class="fa fa-plus mr-1"></i>
        Subscribe
        <span wire:target="subscribeProduct" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
    </button>
    @endif
    @if (session()->has('error'))
        <span class="ml-2 text-danger font-weight-bold">{{ session('error') }}</span>
    @endif
</div>
