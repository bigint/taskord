<div>
    @if ($question)
        <div class="mt-2 text-secondary">
            liked your
            <a class="fw-bold" href="{{ route('question.question', ['slug' => $question->slug]) }}">
                question
            </a>
        </div>
        <div class="mt-3">
            @livewire('question.single-question', [
            'type' => 'question.newest',
            'question' => $question,
            ], key($question->id))
        </div>
    @else
        <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
