<div class="d-flex p-3">
    <img class="avatar-50 rounded me-3" src="{{ Helper::getCDNImage($product->avatar) }}" alt="{{ $product->slug }}'s avatar" />
    <div>
        <div class="fw-bold text-dark">
            {{ $product->name }}
        </div>
        <div class="small text-dark">{{ '#'.$product->slug }}</div>
        @if ($product->description)
        <div class="mt-2 text-dark">{{ $product->description }}</div>
        @endif
    </div>
</div>
