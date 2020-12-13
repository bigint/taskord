<div class="mb-3">
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'questions.newest' ? '' : 'outline-' }}primary me-2" href="{{ route('questions.newest') }}">
        Newest
    </a>
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'questions.unanswered' ? '' : 'outline-' }}primary me-2" href="{{ route('questions.unanswered') }}">
        Unanswered
    </a>
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'questions.popular' ? '' : 'outline-' }}primary me-2" href="{{ route('questions.popular') }}">
        Popular
    </a>
    @auth
    <button type="button" class="mb-2 btn btn-success float-md-right text-white" data-toggle="modal" data-target="#newQuestionModal">
        <i class="fa fa-plus"></i>
        Ask a Question
    </button>
    @livewire('question.create-question')
    @endauth
</div>
