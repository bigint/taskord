<div class="card" wire:init="loadProducts">
    <div class="card-header h6 py-3">
        <div class="h5">Products</div>
        <span class="fw-bold">{{ $readyToLoad ? $count : '···' }}</span>
        total products
    </div>
    <div class="table-responsive">
        @if (!$readyToLoad)
            <div class="card-body text-center mt-3">
                <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                <div class="h6">
                    Loading products...
                </div>
            </div>
        @else
            <table class="table text-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product</th>
                        <th scope="col">Owner</th>
                        <th scope="col">Members</th>
                        <th scope="col">Tasks</th>
                        <th scope="col">Updates</th>
                        <th scope="col">Launched</th>
                        <th scope="col">Launched At</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <th>{{ $product->id }}</th>
                            <td>
                                <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
                                    {{ $product->name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('user.done', ['username' => $product->user->username]) }}"
                                    target="_blank">
                                    {{ '@' . $product->user->username }}
                                </a>
                            </td>
                            <td>
                                {{ $product->members_count }}
                            </td>
                            <td>
                                {{ $product->tasks_count }}
                            </td>
                            <td>
                                {{ $product->product_update_count }}
                            </td>
                            <td>
                                @if ($product->launched)✅@else❌@endif
                            </td>
                            <td>
                                @if ($product->launched_at)
                                    <time datetime="{{ $product->launched_at->format('Y-m-d') }}">
                                        {{ $product->launched_at->format('M d, Y') }}
                                    </time>
                                @else
                                    TBD
                                @endif
                            </td>
                            <td>
                                <time datetime="{{ $product->created_at->format('Y-m-d') }}">
                                    {{ $product->created_at->format('M d, Y') }}
                                </time>
                            </td>
                            <td>
                                <time datetime="{{ $product->updated_at->format('Y-m-d') }}">
                                    {{ $product->updated_at->format('M d, Y') }}
                                </time>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    {{ $readyToLoad ? $products->links() : '' }}
</div>
