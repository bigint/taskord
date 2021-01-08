<div>
    @auth
    @if (auth()->user()->id !== $product->owner->id)
    @if (auth()->user()->hasSubscribed($product))
    <button wire:click="subscribeProduct" wire:loading.attr="disabled" class="btn btn-sm btn-danger mb-2">
        <div wire:loading class="spinner-border spinner-border-sm me-1"></div>
        <x-heroicon-o-minus-circle wire:loading.remove class="heroicon" />
        Unsubscribe
    </button>
    @else
    <button wire:click="subscribeProduct" wire:loading.attr="disabled" class="btn btn-sm btn-primary mb-2">
        <div wire:loading class="spinner-border spinner-border-sm me-1"></div>
        <x-heroicon-o-plus wire:loading.remove class="heroicon" />
        Subscribe
    </button>
    @endif
    @endif
    @endauth
    <div class="small">
        <a class="text-dark" href="{{ route('product.subscribers', ['slug' => $product->slug]) }}">
            <span class="fw-bold">{{ number_format($product->subscribersCount()) }}</span>
            {{ str_plural('Subscriber', $product->subscribersCount()) }}
        </a>
    </div>
</div>
