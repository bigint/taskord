<div>
    @if ($answers->count() === 0)
    <div class="card-body text-center mt-3">
        <i class="fa fa-3x fa-comments mb-3 text-primary"></i>
        <div class="h5">
            No answers found!
        </div>
    </div>
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
