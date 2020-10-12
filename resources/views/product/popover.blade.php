<div class="p-3">
    <img class="rounded-circle avatar-40 mr-3" src="{{ $product->avatar }}" />
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
