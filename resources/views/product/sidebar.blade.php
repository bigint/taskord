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
