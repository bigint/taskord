<div>
    @if (count($questions) === 0)
    <x-empty icon="question" text="No questions asked" />
    @endif
    @foreach ($questions as $question)
        @livewire('question.single-question', [
            'type' => 'question.newest',
            'question' => $question,
        ], key($question->id))
    @endforeach
    
    {{ $questions->links() }}
</div>
