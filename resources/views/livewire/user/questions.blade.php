<div>
    @if (count($questions) === 0)
    <div class="card-body text-center mt-3 mb-3">
        <x-heroicon-o-question-mark-circle class="heroicon-4x text-primary mb-2" />
        <div class="h4">
            No questions asked
        </div>
    </div>
    @endif
    @foreach ($questions as $question)
        @livewire('question.single-question', [
            'type' => 'question.newest',
            'question' => $question,
        ], key($question->id))
    @endforeach

    {{ $questions->links('pagination-links') }}
</div>
