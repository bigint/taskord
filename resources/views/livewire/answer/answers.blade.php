<div>
    @if ($answers->count('id') === 0)
    @include('components.empty', [
        'icon' => 'comments',
        'text' => 'No answers found!',
    ])
    @endif
    @foreach ($answers as $answer)
        @if (!$answer->user->isFlagged or Auth::check() && Auth::user()->staffShip)
            <div class="card mt-4">
                @livewire('answer.single-answer', [
                    'answer' => $answer
                ], key($answer->id))
            </div>
        @endif
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
