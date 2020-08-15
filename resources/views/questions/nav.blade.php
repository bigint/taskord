<div class="mb-3">
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'questions.newest' ? '' : 'outline-' }}primary mr-2" href="{{ route('questions.newest') }}">
        Newest
    </a>
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'questions.unanswered' ? '' : 'outline-' }}primary mr-2" href="{{ route('questions.unanswered') }}">
        Unanswered
    </a>
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'questions.popular' ? '' : 'outline-' }}primary mr-2" href="{{ route('questions.popular') }}">
        Popular
    </a>
    <a class="btn btn-success float-md-right mb-2 text-white" href="{{ route('questions.new') }}">
        <i class="fa fa-plus"></i>
        Ask a Question
    </a>
</div>
