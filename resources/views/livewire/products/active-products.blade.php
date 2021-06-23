<div wire:init="loadActiveProducts">
    <div class="text-uppercase fw-bold text-secondary pb-2">
        <x-heroicon-o-fire class="heroicon text-danger" />
        Active Products
    </div>
    <div class="card mb-4">
        <div class="pt-2 pb-2">
            @if (!$readyToLoad)
                <div class="card-body text-center">
                    <div class="spinner-border spinner-border-sm taskord-spinner text-secondary" role="status"></div>
                </div>
            @endif
            @foreach ($products as $product)
                <div class="py-2 px-3">
                    <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
                        <img loading=lazy class="rounded avatar-30 mt-1 ms-2"
                            src="{{ Helper::getCDNImage($product->avatar, 80) }}" height="30" width="30"
                            alt="{{ $product->slug }}'s avatar" />
                    </a>
                    <a href="{{ route('product.done', ['slug' => $product->slug]) }}"
                        class="ms-2 me-2 align-text-top fw-bold text-dark product-popover"
                        data-id="{{ $product->id }}">
                        {{ $product->name }}
                        @if ($product->launched)
                            <a href="{{ route('products.launched') }}" class="small" data-bs-toggle="tooltip"
                                data-placement="right" title="Launched">
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
                        @foreach ($product->members()->limit(1)->get()
    as $user)
                            <a href="{{ route('user.done', ['username' => $user->username]) }}" class="user-popover"
                                data-id="{{ $user->id }}">
                                <img loading=lazy class="rounded-circle avatar-30 me-1"
                                    src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="30" width="30"
                                    alt="{{ $user->username }}'s avatar" />
                            </a>
                        @endforeach
                        <a href="{{ route('user.done', ['username' => $product->user->username]) }}"
                            class="user-popover" data-id="{{ $product->user->id }}">
                            <img loading=lazy class="rounded-circle avatar-30 me-0"
                                src="{{ Helper::getCDNImage($product->user->avatar, 80) }}" height="30" width="30"
                                alt="{{ $product->user->username }}'s avatar" />
                        </a>
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>
