<div class="d-flex p-3">
    <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
        <img loading=lazy class="avatar-50 rounded me-3" src="{{ Helper::getCDNImage($product->avatar, 80) }}" height="50" width="50" alt="{{ $product->slug }}'s avatar" />
    </a>
    <div>
        <a class="fw-bold text-dark" href="{{ route('product.done', ['slug' => $product->slug]) }}">
            {{ $product->name }}
        </a>
        <div>
            <a class="small text-dark" href="{{ route('product.done', ['slug' => $product->slug]) }}">{{ '#'.$product->slug }}</a>
        </div>
        @if ($product->description)
        <div class="mt-2 text-dark">{{ $product->description }}</div>
        @endif
    </div>
</div>
