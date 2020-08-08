<div class="col-sm">
    @if (Auth::check() and Auth::user()->staffShip or Auth::check() and Auth::id() === $product->user->id)
    <div class="card mb-4">
        <div class="card-body">
            @if (Auth::user()->staffShip)
            <button class="btn btn-block btn-success text-white font-weight-bold">
                <i class="fa fa-bell mr-1"></i>
                Write a product update
            </button>
            @endif
            <a class="btn btn-block btn-success text-white font-weight-bold" href="{{ route('product.edit', ['slug' => $product->slug]) }}">
                <i class="fa fa-edit mr-1"></i>
                Edit Product
            </a>
        </div>
    </div>
    @endif
    @if ($product->website or $product->twitter or $product->producthunt or $product->github)
    <div class="card mb-4">
        <div class="card-header">
            Social
        </div>
        <ul class="list-group list-group-flush">
            @if ($product->website)
            <a class="list-group-item link-dark" href="{{ $product->website }}">
                <i class="fa fa-link mr-1"></i>
                {{ Helper::removeProtocol($product->website) }}
            </a>
            @endif
            @if ($product->producthunt)
            <a class="list-group-item link-dark" href="{{ $product->producthunt }}">
                <i class="fa fa-product-hunt mr-1"></i>
                {{ Helper::removeProtocol($product->producthunt) }}
            </a>
            @endif
            @if ($product->twitter)
            <a class="list-group-item link-dark" href="https://twitter.com/{{ $product->twitter }}">
                <i class="fa fa-twitter mr-1"></i>
                {{ $product->twitter }}
            </a>
            @endif
            @if ($product->github)
            <a class="list-group-item link-dark" href="https://github.com/{{ $product->github }}">
                @if (Auth::check() && Auth::user()->darkMode)
                <i class="fa fa-github text-white mr-1"></i>
                @else
                <i class="fa fa-github mr-1"></i>
                @endif
                {{ $product->github }}
            </a>
            @endif
        </ul>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header">
            Creator
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item pt-2 pb-2">
                <a href="{{ route('user.done', ['username' => $product->user->username]) }}">
                    <img class="rounded-circle avatar-30" src="{{ $product->user->avatar }}" />
                </a>
                <a href="{{ route('user.done', ['username' => $product->user->username]) }}" class="ml-2 align-middle font-weight-bold text-dark">
                    @if ($product->user->firstname or $product->user->lastname)
                        {{ $product->user->firstname }}{{ ' '.$product->user->lastname }}
                    @else
                        {{ $product->user->username }}
                    @endif
                </a>
            </li>
        </ul>
    </div>
</div>
