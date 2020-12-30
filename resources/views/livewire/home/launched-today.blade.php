<div wire:init="loadLaunchedToday">
    @if (count($launched_today) > 0)
    <div class="pb-2 h5">
        <x-heroicon-o-lightning-bolt class="heroicon-2x ms-1 text-secondary" />
        Launched Today
    </div>
    <div class="card mb-4">
        <ul class="list-group list-group-flush">
            @foreach ($launched_today->take(5) as $product)
            <li class="list-group-item p-3">
                <div class="d-flex align-items-center">
                    <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
                        <img loading=lazy class="rounded avatar-50" src="{{ Helper::getCDNImage($product->avatar, 160) }}" height="50" width="50" alt="{{ $product->slug }}'s avatar" height="50" width="50" />
                    </a>
                    <span class="ms-3">
                        <a href="{{ route('product.done', ['slug' => $product->slug]) }}" class="me-2 h5 align-text-top fw-bold text-dark">
                            {{ $product->name }}
                            @if ($product->launched)
                                <a href="{{ route('products.launched') }}" class="small" data-bs-toggle="tooltip" data-placement="right" title="Launched">
                                    🚀
                                </a>
                            @endif
                        </a>
                        <div>{{ $product->description }}</div>
                    </span>
                    <span class="ms-auto">
                        @if ($product->members()->count() > 1)
                            <span class="me-2 mt-1 text-secondary fw-bold">+{{ $product->members()->count() - 1 }} more</span>
                        @endif
                        @foreach ($product->members()->limit(1)->get() as $user)
                        <a
                            href="{{ route('user.done', ['username' => $user->username]) }}"
                            class="user-popover"
                            data-id="{{ $user->id }}"
                        >
                            <img loading=lazy class="rounded-circle avatar-30 mt-1 me-1" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="30" width="30" alt="{{ $user->username }}'s avatar" />
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
            </li>
            @endforeach
        </ul>
        @if (count($launched_today) > 5)
        <div class="card-footer">
            <a class="fw-bold" href="{{ route('products.newest') }}">More Products...</a>
        </div>
        @endif
    </div>
    @endif
</div>
