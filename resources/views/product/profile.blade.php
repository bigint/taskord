<div class="card">
    <div class="card-body d-flex align-items-center">
        <img class="rounded avatar-120" src="{{ $product->avatar }}" />
        <div class="ml-4">
            <div class="h5 mb-0">
                {{ $product->name }}
                @if ($product->launched)
                    <span class="ml-1 small" title="Launched">
                        {{ Emoji::rocket() }}
                    </span>
                @endif
                @if ($product->deprecated)
                    <span class="ml-1 small" title="Deprecated">
                        <i class="fa fa-ghost text-danger"></i>
                    </span>
                @endif
                @auth
                @if (Auth::user()->staffShip)
                    <span class="ml-1 text-secondary small">#{{ $product->id }}</span>
                @endif
                @endauth
            </div>
            <div class="text-black-50 mb-2">
                {{ "#" . $product->slug }}
            </div>
            @livewire('product.subscribe', [
                'product' => $product
            ])
            @if ($product->description)
            <div class="mt-3">
                {{ $product->description }}
            </div>
            @endif
            <div class="small mt-3">
                <i class="fa fa-calendar-alt mr-1 text-black-50"></i>
                <span>Lauched at {{ Carbon::parse($product->launched_at)->format("F Y") }}</span>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted">
        <a class="text-dark font-weight-bold mr-4" href="{{ route('product.done', ['slug' => $product->slug]) }}">
            <span class="@if (Route::currentRouteName() === 'product.done') text-primary @endif">Done</span>
            <span class="small font-weight-normal text-black-50">{{ number_format($done_count) }}</span>
        </a>
        <a class="text-dark font-weight-bold mr-4" href="{{ route('product.pending', ['slug' => $product->slug]) }}">
            <span class="@if (Route::currentRouteName() === 'product.pending') text-primary @endif">Pending</span>
            <span class="small font-weight-normal text-black-50">{{ number_format($pending_count) }}</span>
        </a>
        <a class="text-dark font-weight-bold mr-4"href="{{ route('product.updates', ['slug' => $product->slug]) }}">
            <span class="@if (Route::currentRouteName() === 'product.updates') text-primary @endif">Updates</span>
            <span class="small font-weight-normal text-black-50">{{ number_format($updates_count) }}</span>
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
