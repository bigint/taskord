<div>
    @auth
        @if (auth()->user()->id !== $product->user->id)
            @if (auth()->user()->hasSubscribed($product))
                <button wire:click="subscribeProduct" wire:loading.attr="disabled"
                    class="btn btn-sm btn-outline-danger rounded-pill mb-2">
                    <div wire:loading wire:target="subscribeProduct" class="spinner-border spinner-border-sm me-1"></div>
                    <x-heroicon-o-minus-circle wire:loading.remove wire:target="subscribeProduct"
                        class="heroicon heroicon-15px" />
                    Unsubscribe
                </button>
            @else
                <button wire:click="subscribeProduct" wire:loading.attr="disabled"
                    class="btn btn-sm btn-outline-primary rounded-pill mb-2">
                    <div wire:loading wire:target="subscribeProduct" class="spinner-border spinner-border-sm me-1"></div>
                    <x-heroicon-o-plus wire:loading.remove wire:target="subscribeProduct" class="heroicon heroicon-15px" />
                    Subscribe
                </button>
            @endif
        @endif
    @endauth
    <div class="small">
        <a class="text-dark" href="{{ route('product.subscribers', ['slug' => $product->slug]) }}">
            <span class="fw-bold">{{ number_format($product->subscribersCount()) }}</span>
            {{ pluralize('Subscriber', $product->subscribersCount()) }}
        </a>
    </div>
</div>
