<div>
    @if ($comments->count('id') === 0)
    <div class="card-body text-center mt-3">
        <i class="fa fa-3x fa-comments mb-3 text-primary"></i>
        <div class="h5">
            No comments found!
        </div>
    </div>
    @endif
    <ul class="list-group mt-4" wire:poll.5s>
    @foreach ($comments as $comment)
        @livewire('task.single-comment', [
            'comment' => $comment,
        ], key($comment->id))
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
