<div class="card">
    <div class="card-body d-flex align-items-center">
        <img class="rounded avatar-120" src="{{ $product->avatar }}"/>
        <div class="ml-4">
            <div class="h5 mb-0">
                {{ $product->name }}
                @if ($product->launched)
                    <a href="{{ route('products.launched') }}" class="ml-2 small" data-toggle="tooltip" data-placement="right" title="Launched">
                        {{ Emoji::rocket() }}
                    </a>
                @endif
            </div>
            <div class="text-black-50 mb-2">
                {{ "#" . $product->slug }}
            </div>
            @if (Auth::check() && Auth::id() !== $product->user->id)
                @livewire('product.subscribe', [
                    'product' => $product
                ])
            @endif
            <span class="small">
                <span class="font-weight-bold">{{ $product->subscribers->count() }}</span> Subscribers
            </span>
            @if ($product->description)
            <div class="mt-3">
                {{ $product->description }}
            </div>
            @endif
            <div class="mt-2 small">
                @if ($product->website)
                    <a class="mr-3" href="{{ $product->website }}">
                        <i class="fa fa-link mr-1"></i>
                        {{ Helper::removeProtocol($product->website) }}
                    </a>
                @endif
                @if ($product->twitter)
                    <a class="mr-3" href="https://twitter.com/{{ $product->twitter }}">
                        <i class="fa fa-twitter mr-1"></i>
                        {{ $product->twitter }}
                    </a>
                @endif
                @if ($product->producthunt)
                    <a class="mr-3" href="https://producthunt.com/{{ $product->producthunt }}">
                        <i class="fa fa-product-hunt mr-1"></i>
                        {{ $product->producthunt }}
                    </a>
                @endif
            </div>
            <div class="small mt-3 text-black-50">
                <span class="mr-3">{{ Emoji::calendar() }} Lauched at {{ Carbon::parse($product->launched_at)->format("F Y") }}</span>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted">
        <a class="text-dark font-weight-bold mr-4" href="{{ route('product.done', ['slug' => $product->slug]) }}">
            <span class="@if (Route::currentRouteName() === 'product.done') text-primary @endif">Done</span>
            <span class="small font-weight-normal text-black-50">{{ $done_count }}</span>
        </a>
        <a class="text-dark font-weight-bold mr-4" href="{{ route('product.pending', ['slug' => $product->slug]) }}">
            <span class="@if (Route::currentRouteName() === 'product.pending') text-primary @endif">Pending</span>
            <span class="small font-weight-normal text-black-50">{{ $pending_count }}</span>
        </a>
        @if (Auth::check() && Auth::user()->staffShip)
        <a class="text-dark font-weight-bold mr-4" href="">
            Updates <span class="small font-weight-normal text-black-50">1000</span>
        </a>
        @endif
        @if (Auth::check() && Auth::user()->staffShip)
        <a class="text-dark font-weight-bold mr-4" href="">
            Stats
        </a>
        @endif
    </div>
</div>
