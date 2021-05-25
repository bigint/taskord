<div wire:init="loadProducts">
    @if (!$ready_to_load)
        <div class="card-body text-center mt-3 mb-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading products...
            </div>
        </div>
    @endif
    @if ($ready_to_load and count($products) === 0)
        <div class="card-body text-center mt-3 mb-3">
            <x-heroicon-o-cube class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                No products made
            </div>
        </div>
    @endif
    @foreach ($products as $product)
        <div class="card mb-2">
            <div class="card-body">
                <livewire:product.single-product :product="$product" :wire-key="$product->id" />
            </div>
        </div>
    @endforeach

    {{ $ready_to_load ? $products->links() : '' }}
</div>
