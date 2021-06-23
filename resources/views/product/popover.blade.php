<div class="d-flex p-3">
    <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
        <img loading=lazy class="avatar-50 rounded me-3" src="{{ Helper::getCDNImage($product->avatar, 80) }}"
            height="50" width="50" alt="{{ $product->slug }}'s avatar" />
    </a>
    <div>
        <a class="fw-bold text-dark" href="{{ route('product.done', ['slug' => $product->slug]) }}">
            {{ $product->name }}
        </a>
        <div>
            <a class="small text-dark fw-normal"
                href="{{ route('product.done', ['slug' => $product->slug]) }}">{{ '#' . $product->slug }}</a>
        </div>
        @if ($product->description)
            <div class="mt-2 text-dark fw-normal">{{ $product->description }}</div>
        @endif
        <div class="mt-2 text-secondary d-flex align-items-center">
            @php
                $members_count = $product->user()->count() + $product->members()->count();
            @endphp
            <x-heroicon-o-users class="heroicon" />
            <div class="ms-1">{{ $members_count }} {{ pluralize('member', $members_count) }} in the team</div>
        </div>
    </div>
</div>
