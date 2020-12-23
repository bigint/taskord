<div>
    @auth
    @if (Auth::id() !== $product->owner->id)
    @if (Auth::user()->hasSubscribed($product))
    <button wire:click="subscribeProduct" wire:loading.attr="disabled" class="btn btn-sm btn-danger mb-2">
        <x-heroicon-o-minus-circle class="heroicon" />
        Unsubscribe
    </button>
    @else
    <button wire:click="subscribeProduct" wire:loading.attr="disabled" class="btn btn-sm btn-primary mb-2">
        <x-heroicon-o-plus class="heroicon" />
        Subscribe
    </button>
    @endif
    @endif
    @endauth
    <div class="small">
        <a class="text-dark" href="{{ route('product.subscribers', ['slug' => $product->slug]) }}">
            <span class="fw-bold">{{ number_format($product->subscribersCount()) }}</span>
            {{ $product->subscribersCount() <= 1 ? 'Subscriber' : 'Subscribers' }}
        </a>
    </div>
</div>
