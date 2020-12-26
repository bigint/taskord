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
            'type' => $type,
            'question' => $question,
        ], key($question->id))
    @endforeach
    @if ($questions->hasMorePages())
        @livewire('question.load-more', [
            'type' => $type,
            'page' => $page,
            'perPage' => $perPage
        ])
    @endif
</div>
