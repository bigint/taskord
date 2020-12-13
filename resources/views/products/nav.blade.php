<div class="mb-3">
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'products.newest' ? '' : 'outline-' }}primary me-2" href="{{ route('products.newest') }}">
        Newest
    </a>
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'products.launched' ? '' : 'outline-' }}primary me-2" href="{{ route('products.launched') }}">
        Launched
    </a>
    @auth
    <button type="button" class="mb-2 btn btn-success float-md-end text-white" data-bs-toggle="modal" data-bs-target="#newProductModal">
        <i class="fa fa-plus"></i>
        Add your Product
    </button>
    @livewire('product.new-product')
    @endauth
</div>
