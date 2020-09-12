<div>
    @if (count($products) === 0)
    @include('components.empty', [
        'icon' => 'box-open',
        'text' => 'No products made',
    ])
    @endif
    @foreach ($products as $product)
    <div class="card mb-2">
        <div class="card-body d-flex align-items-center">
            <img class="rounded avatar-50 mt-1 ml-2" src="{{ $product->avatar }}" height="50" width="50" />
            <span class="ml-3">
                <a href="{{ route('product.done', ['slug' => $product->slug]) }}" class="mr-2 h5 align-text-top font-weight-bold text-dark">
                    {{ $product->name }}
                </a>
                <div>{{ $product->description }}</div>
            </span>
            <a class="ml-auto" href="{{ route('user.done', ['username' => $product->owner->username]) }}">
                <img class="rounded-circle float-right avatar-30 mt-1 ml-2" src="{{ $product->owner->avatar }}" height="50" width="50" />
            </a>
        </div>
    </div>
    @endforeach
    
    {{ $products->links() }}
</div>
