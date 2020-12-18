<div>
    @if (count($products) === 0)
    <x-empty icon="box-open" text="No products made" />
    @endif
    @foreach ($products as $product)
    <div class="card mb-2">
        <div class="card-body d-flex align-items-center">
            <img class="rounded avatar-50 mt-1 ms-2" src="{{ $product->avatar }}" height="50" width="50" alt="{{ $product->slug }}'s avatar" />
            <span class="ms-3">
                <a href="{{ route('product.done', ['slug' => $product->slug]) }}" class="me-2 h5 align-text-top fw-bold text-dark">
                    {{ $product->name }}
                </a>
                <div>{{ $product->description }}</div>
            </span>
            <span class="ms-auto">
                @if ($product->members()->count() > 1)
                    <span class="me-2 text-secondary fw-bold">+{{ $product->members()->count() - 1 }} more</span>
                @endif
                @foreach ($product->members()->limit(1)->get() as $user)
                <a
                    href="{{ route('user.done', ['username' => $user->username]) }}"
                    id="user-hover"
                    data-id="{{ $user->id }}"
                >
                    <img class="rounded-circle avatar-30 me-1" src="{{ $user->avatar }}" alt="{{ $user->username }}'s avatar" />
                </a>
                @endforeach
                <a
                    href="{{ route('user.done', ['username' => $product->owner->username]) }}"
                    id="user-hover"
                    data-id="{{ $product->owner->id }}"
                >
                    <img class="rounded-circle avatar-30 me-0" src="{{ $product->owner->avatar }}" alt="{{ $product->owner->username }}'s avatar" />
                </a>
            </span>
        </div>
    </div>
    @endforeach

    {{ $products->links() }}
</div>
