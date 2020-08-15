<div>
    @foreach ($questions as $question)
        @livewire('questions.single-question', [
            'type' => $type,
            'question' => $question,
        ], key($question->id))
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
