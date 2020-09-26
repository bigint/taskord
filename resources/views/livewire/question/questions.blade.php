<div>
    @foreach ($questions as $question)
        @livewire('question.single-question', [
            'type' => $type,
            'question' => $question,
        ], key($question->id))
    @endforeach
    <div class="mt-4">
        @if ($questions->hasMorePages())
            @livewire('question.load-more', [
                'type' => $type,
                'page' => $page,
                'perPage' => $perPage
            ])
        @endif
    </div>
</div>
