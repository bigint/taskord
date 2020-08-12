<div>
    @foreach ($questions as $question)
        @if (!$question->user->isFlagged or Auth::check() && Auth::user()->staffShip)
            @livewire('questions.single-question', [
                'type' => $type,
                'question' => $question,
            ], key($question->id))
        @endif
    @endforeach
    <div class="mt-4">
        @if ($questions->hasMorePages())
            @livewire('questions.load-more', [
                'type' => $type,
                'page' => $page,
                'perPage' => $perPage
            ])
        @endif
    </div>
</div>
