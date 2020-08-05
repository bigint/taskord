<div>
    @if (count($questions) === 0)
    <div class="card-body text-center">
        <i class="fa fa-3x fa-question mb-3 text-primary"></i>
        <div class="h5">
            No questions asked!
        </div>
    </div>
    @endif
    @foreach ($questions as $question)
        @livewire('questions.single-question', [
            'type' => 'question.newest',
            'question' => $question,
        ], key($question->id))
    @endforeach
    
    {{ $questions->links() }}
</div>
