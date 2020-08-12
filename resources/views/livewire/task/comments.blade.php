<div>
    @if ($comments->count('id') === 0)
    @include('components.empty', [
        'icon' => 'comments',
        'text' => 'No comments found!',
    ])
    @endif
    <ul class="list-group mt-4" wire:poll.5s>
    @foreach ($comments as $comment)
        @if (!$comment->user->isFlagged or Auth::check() && Auth::user()->staffShip)
            @livewire('task.single-comment', [
                'comment' => $comment,
            ], key($comment->id))
        @endif
    @endforeach
    </ul>
    <div class="mt-4">
        @if ($comments->hasMorePages())
            @livewire('task.load-more', [
                'task' => $task,
                'page' => $page,
                'perPage' => $perPage
            ])
        @endif
    </div>
</div>
