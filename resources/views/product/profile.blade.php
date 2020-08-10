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
            @auth
            @if (Auth::id() !== $product->user->id)
                @livewire('product.subscribe', [
                    'product' => $product
                ])
            @endif
            @endauth
            <span class="small">
                <span class="font-weight-bold">{{ $product->likes->count() }}</span> Subscribers
            </span>
            @if ($product->description)
            <div class="mt-3">
                {{ $product->description }}
            </div>
            @endif
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
        <a class="text-dark font-weight-bold mr-4"href="{{ route('product.updates', ['slug' => $product->slug]) }}">
            <span class="@if (Route::currentRouteName() === 'product.updates') text-primary @endif">Updates</span>
        </a>
        @auth
        @if (Auth::user()->staffShip)
        <a class="text-dark font-weight-bold mr-4" href="">
            Stats
        </a>
        @endif
        @endauth
    </div>
</div>
