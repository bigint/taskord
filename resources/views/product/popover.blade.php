<div class="d-flex p-2">
    <div>
        <div class="font-weight-bold text-dark">
            {{ $product->name }}
        </div>
        <div class="small text-dark">{{ '#'.$product->slug }}</div>
        @if ($product->description)
        <div class="mt-2 text-dark">{{ $product->description }}</div>
        @endif
    </div>
</div>
