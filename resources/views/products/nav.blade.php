<div class="mb-3">
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'products.newest' ? '' : 'outline-' }}primary mr-2" href="{{ route('products.newest') }}">
        Newest
    </a>
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'products.launched' ? '' : 'outline-' }}primary mr-2" href="{{ route('products.launched') }}">
        Launched
    </a>
    <a class="mb-2 btn btn-success float-md-right text-white" href="{{ route('products.new') }}">
        <i class="fa fa-plus"></i>
        Add your Product
    </a>
</div>
