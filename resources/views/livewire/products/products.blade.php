<div>
    @foreach ($products as $key => $groupedProducts)
        <div class="h5 mb-3 mt-4">
            @if (Carbon::parse($groupedProducts[$loop->index]->created_at)->weekNumberInMonth === 1)
                <span>1st week of</span>
            @elseif (Carbon::parse($groupedProducts[$loop->index]->created_at)->weekNumberInMonth === 2)
                <span>2nd week of</span>
            @elseif (Carbon::parse($groupedProducts[$loop->index]->created_at)->weekNumberInMonth === 3)
                <span>3rd week of</span>
            @elseif (Carbon::parse($groupedProducts[$loop->index]->created_at)->weekNumberInMonth === 4)
                <span>4th week of</span>
            @elseif (Carbon::parse($groupedProducts[$loop->index]->created_at)->weekNumberInMonth === 5)
                <span>5th week of</span>
            @endif
            {{ Carbon::parse($groupedProducts[$loop->index]->created_at)->englishMonth }}
        </div>
        @foreach ($groupedProducts as $product)
        <div class="card mb-2">
            <div class="card-body d-flex align-items-center">
                <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
                    <img class="rounded avatar-50 mt-1 ml-2" src="{{ $product->avatar }}" height="50" width="50" />
                </a>
                <span class="ml-3">
                    <a href="{{ route('product.done', ['slug' => $product->slug]) }}" class="mr-2 h5 align-text-top font-weight-bold text-dark">
                        {{ $product->name }}
                        @if ($product->launched)
                            <a href="{{ route('products.launched') }}" class="small" data-toggle="tooltip" data-placement="right" title="Launched">
                                {{ Emoji::rocket() }}
                            </a>
                        @endif
                    </a>
                    <div>{{ $product->description }}</div>
                </span>
                <a class="ml-auto" href="{{ route('user.done', ['username' => $product->user->username]) }}">
                    <img class="rounded-circle float-right avatar-30 mt-1 ml-2" src="{{ $product->user->avatar }}" height="50" width="50" />
                </a>
            </div>
        </div>
        @endforeach
    @endforeach
    @if ($products->hasMorePages())
        @livewire('products.load-more', [
            'type' => $type,
            'page' => $page,
            'perPage' => $perPage
        ])
    @endif
</div>
