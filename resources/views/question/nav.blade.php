<div class="mb-3">
    <a class="mb-2 btn btn-{{ Route::is('questions.newest') ? '' : 'outline-' }}primary rounded-pill me-2"
        href="{{ route('questions.newest') }}">
        Newest
    </a>
    <a class="mb-2 btn btn-{{ Route::is('questions.unanswered') ? '' : 'outline-' }}primary rounded-pill me-2"
        href="{{ route('questions.unanswered') }}">
        Unanswered
    </a>
    <a class="mb-2 btn btn-{{ Route::is('questions.popular') ? '' : 'outline-' }}primary rounded-pill me-2"
        href="{{ route('questions.popular') }}">
        Popular
    </a>
    @auth
        <a href="{{ route('questions.new') }}" class="mb-2 btn btn-outline-success rounded-pill float-md-end">
            <x-heroicon-o-plus class="heroicon" />
            Ask a Question
        </a>
    @endauth
</div>
