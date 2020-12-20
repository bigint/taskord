<div class="d-flex p-3">
<<<<<<< HEAD
    <img loading=lazy class="avatar-50 rounded me-3" src="{{ Helper::getCDNImage($product->avatar, 50) }}" alt="{{ $product->slug }}'s avatar" />
=======
    <img loading=lazy class="avatar-50 rounded me-3" src="{{ Helper::getCDNImage($product->avatar, 80) }}" alt="{{ $product->slug }}'s avatar" />
>>>>>>> b18e0c01a7a50af04ce03ea488741e1ccafd70c7
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
