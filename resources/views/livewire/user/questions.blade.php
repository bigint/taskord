<div>
    @if (count($questions) === 0)
    @include('components.empty', [
        'icon' => 'question',
        'text' => 'No questions asked',
    ])
    @endif
    @foreach ($questions as $question)
        @livewire('questions.single-question', [
            'type' => 'question.newest',
            'question' => $question,
        ], key($question->id))
    @endforeach
    
    {{ $questions->links() }}
</div>
