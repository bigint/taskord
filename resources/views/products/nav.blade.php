<div class="mb-3">
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'products.newest' ? '' : 'outline-' }}primary me-2" href="{{ route('products.newest') }}">
        Newest
    </a>
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'products.launched' ? '' : 'outline-' }}primary me-2" href="{{ route('products.launched') }}">
        Launched
    </a>
    @auth
    <a type="button" class="mb-2 btn btn-success float-md-end text-white" href="{{ route('products.new') }}">
        <x-heroicon-o-plus class="heroicon" />
        Add your Product
    </a>
    @endauth
</div>
