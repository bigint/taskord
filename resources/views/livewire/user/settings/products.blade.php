<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3">
            <span class="h5">Products</span>
            <div>Update your associated products.</div>
        </div>
        <div class="card-body-flush">
            @if ($products)
                <ul class="list-group list-group-flush">
                    @foreach ($products as $product)
                        <li class="list-group-item d-flex align-items-center">
                            <a href="{{ route('product.done', ['slug' => $product->slug]) }}" class="link-dark">
                                {{ $product->name }}
                            </a>
                            @if ($product->user->username == $user->username)
                                <span class="badge bg-success ms-2">Owns</span>
                            @else
                                <span class="badge bg-secondary ms-2">Member</span>
                                <a href="#" class="badge bg-danger link-light ms-2"
                                    wire:click.prevent="leaveProduct({{ $product->id }})"
                                    wire:loading.attr="disabled">
                                    Leave
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
