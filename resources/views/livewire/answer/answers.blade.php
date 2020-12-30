<div wire:init="loadAnswers">
    @if (!$readyToLoad)
    <div class="card-body text-center mt-3">
        <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
        <div class="h6">
            Loading Answers...
        </div>
    </div>
    @endif
    @if ($readyToLoad and count($answers) === 0)
    <div class="card-body text-center mt-3 mb-3">
        <x-heroicon-o-chat-alt-2 class="heroicon-4x text-primary mb-2" />
        <div class="h4">
            No answers found!
        </div>
    </div>
    @endif
    @foreach ($answers as $answer)
        <div class="card mt-3">
            @livewire('answer.single-answer', [
                'answer' => $answer
            ], key($answer->id))
        </div>
    @endforeach
    <div class="mt-3">
    @if ($readyToLoad and $answers->hasMorePages())
        @livewire('answer.load-more', [
            'question' => $answer->question,
            'page' => $page,
            'perPage' => $perPage
        ])
    @endif
    </div>
</div>
