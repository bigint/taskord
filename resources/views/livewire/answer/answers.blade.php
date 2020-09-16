<div>
    @if ($answers->count('id') === 0)
    <x-empty icon="comments" text="No answers found!"/>
    @endif
    @foreach ($answers as $answer)
        <div class="card mt-4">
            @livewire('answer.single-answer', [
                'answer' => $answer
            ], key($answer->id))
        </div>
    @endforeach
    <div class="mt-4">
    @if ($answers->hasMorePages())
        @livewire('answer.load-more', [
            'question' => $answer->question,
            'page' => $page,
            'perPage' => $perPage
        ])
    @endif
    </div>
</div>
