<div class="d-flex p-3">
    <div>
        <div class="font-weight-bold text-white">
            {{ $product->name }}
        </div>
        <div class="small text-white">{{ '#'.$product->slug }}</div>
        @if ($product->description)
        <div class="mt-2 text-white">{{ $product->description }}</div>
        @endif
    </div>
</div>
