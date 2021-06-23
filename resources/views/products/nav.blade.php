<div class="mb-3">
    <a class="mb-2 btn btn-{{ Route::is('products.newest') ? '' : 'outline-' }}primary rounded-pill me-2"
        href="{{ route('products.newest') }}">
        Newest
    </a>
    <a class="mb-2 btn btn-{{ Route::is('products.launched') ? '' : 'outline-' }}primary rounded-pill me-2"
        href="{{ route('products.launched') }}">
        Launched
    </a>
    @auth
        <a type="button" class="mb-2 btn btn-outline-success rounded-pill float-md-end"
            href="{{ route('products.new') }}">
            <x-heroicon-o-plus class="heroicon" />
            Add your Product
        </a>
    @endauth
</div>
