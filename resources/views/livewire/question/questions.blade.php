<div wire:init="loadQuestions">
    @if (!$readyToLoad)
        <div class="card-body text-center mt-3 mb-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading questions...
            </div>
        </div>
    @endif
    @if ($readyToLoad and count($questions) === 0)
        <div class="card-body text-center mt-3 mb-3">
            <x-heroicon-o-question-mark-circle class="heroicon heroicon-60px text-primary mb-2" />
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
    @if ($readyToLoad and $questions->hasMorePages())
        <livewire:question.load-more :type="$type" :page="$page" :perPage="$perPage" />
    @endif
</div>
