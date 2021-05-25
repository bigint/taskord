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
                No products found!
            </div>
        </div>
    @endif
    @foreach ($products as $key => $groupedProducts)
        <div class="h5 mb-3 mt-4">
            @if (carbon($groupedProducts[$loop->index]->created_at)->weekNumberInMonth === 1)
                <span>1st week of</span>
            @elseif (carbon($groupedProducts[$loop->index]->created_at)->weekNumberInMonth === 2)
                <span>2nd week of</span>
            @elseif (carbon($groupedProducts[$loop->index]->created_at)->weekNumberInMonth === 3)
                <span>3rd week of</span>
            @elseif (carbon($groupedProducts[$loop->index]->created_at)->weekNumberInMonth === 4)
                <span>4th week of</span>
            @elseif (carbon($groupedProducts[$loop->index]->created_at)->weekNumberInMonth === 5)
                <span>5th week of</span>
            @endif
            {{ carbon($groupedProducts[$loop->index]->created_at)->englishMonth }}
        </div>
        @foreach ($groupedProducts as $product)
            <div class="card mb-2">
                <div class="card-body">
                    <livewire:product.single-product :product="$product" :wire-key="$product->id" />
                </div>
            </div>
        @endforeach
    @endforeach
    @if ($ready_to_load and $products->hasMorePages())
        <livewire:products.load-more :type="$type" :page="$page" :perPage="$perPage" />
    @endif
</div>
