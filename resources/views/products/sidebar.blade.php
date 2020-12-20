<div class="text-uppercase fw-bold text-secondary pb-2">
    <x-heroicon-o-fire class="heroicon text-danger" />
    Active Products
</div>
<div class="card mb-4">
    <div class="pt-2 pb-2">
        @foreach ($products as $product)
        <div class="py-2 px-3">
            <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
                <img loading=lazy class="rounded avatar-30 mt-1 ms-2" src="{{ Helper::getCDNImage($product->avatar, 50) }}" height="50" width="50" alt="{{ $product->slug }}'s avatar" />
            </a>
            <a
                href="{{ route('product.done', ['slug' => $product->slug]) }}"
                class="ms-2 me-2 align-text-top fw-bold text-dark product-hover"
                data-id="{{ $product->id }}"
            >
                {{ $product->name }}
                @if ($product->launched)
                    <a href="{{ route('products.launched') }}" class="small" data-bs-toggle="tooltip" data-placement="right" title="Launched">
                        🚀
                    </a>
                @endif
            </a>
            <span class="small text-secondary ms-3">
                <x-heroicon-o-check class="heroicon text-success" />
                {{ $product->tasks->count('id') }}
                {{ $product->tasks->count('id') == 1 ? 'Task' : 'Tasks' }}
            </span>
            <span class="float-end">
                @foreach ($product->members()->limit(1)->get() as $user)
                <a
                    href="{{ route('user.done', ['username' => $user->username]) }}"
                    class="user-hover"
                    data-id="{{ $user->id }}"
                >
                    <img loading=lazy class="rounded-circle avatar-30 me-1" src="{{ Helper::getCDNImage($user->avatar, 50) }}" alt="{{ $user->username }}'s avatar" />
                </a>
                @endforeach
                <a
                    href="{{ route('user.done', ['username' => $product->owner->username]) }}"
                    class="user-hover"
                    data-id="{{ $product->owner->id }}"
                >
                    <img loading=lazy class="rounded-circle avatar-30 me-0" src="{{ Helper::getCDNImage($product->owner->avatar, 50) }}" alt="{{ $product->owner->username }}'s avatar" />
                </a>
            </span>
        </div>
        @endforeach
    </div>
</div>
