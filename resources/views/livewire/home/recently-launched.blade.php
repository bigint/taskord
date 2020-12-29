<div wire:init="loadRecentlyLaunched">
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Recently Launched
    </div>
    <div class="card mb-4">
        <div class="pt-2 pb-2">
        @if (!$readyToLoad)
        <div class="card-body text-center">
            <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
        </div>
        @endif
        @foreach ($products as $product)
        <div class="py-2 px-3">
            <a
                href="{{ route('product.done', ['slug' => $product->slug]) }}"
                class="product-popover"
                data-id="{{ $product->id }}"
            >
                <img loading=lazy class="rounded avatar-30" src="{{ Helper::getCDNImage($product->avatar, 160) }}" height="30" width="30" alt="{{ $product->slug }}'s avatar" />
            </a>
            <a
                href="{{ route('product.done', ['slug' => $product->slug]) }}"
                class="ms-2 me-2 align-text-top fw-bold text-dark product-popover"
                data-id="{{ $product->id }}"
            >
                {{ $product->name }}
                @if ($product->launched)
                    <a href="{{ route('products.launched') }}" class="small" data-bs-toggle="tooltip" data-placement="right" title="Launched">
                        🚀
                    </a>
                @endif
            </a>
            <span class="float-end">
                @foreach ($product->members()->limit(1)->get() as $user)
                <a
                    href="{{ route('user.done', ['username' => $user->username]) }}"
                    class="user-popover"
                    data-id="{{ $user->id }}"
                >
                    <img loading=lazy class="rounded-circle avatar-30 mt-1 me-1" src="{{ Helper::getCDNImage($user->avatar, 160) }}" height="30" width="30" alt="{{ $user->username }}'s avatar" />
                </a>
                @endforeach
                <a
                    href="{{ route('user.done', ['username' => $product->owner->username]) }}"
                    class="user-popover"
                    data-id="{{ $product->owner->id }}"
                >
                    <img loading=lazy class="rounded-circle avatar-30 mt-1 me-0" src="{{ Helper::getCDNImage($product->owner->avatar, 80) }}" height="30" width="30" alt="{{ $product->owner->username }}'s avatar" />
                </a>
            </span>
        </div>
        @endforeach
        </div>
        @if ($readyToLoad)
        <div class="card-footer">
            <a class="fw-bold" href="{{ route('products.newest') }}">More Products...</a>
        </div>
        @endif
    </div>
</div>
