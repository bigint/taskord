<div>
    @if ($comments->count() === 0)
    <div class="card-body text-center mt-3">
        <i class="fa fa-3x fa-comments mb-3 text-primary"></i>
        <div class="h5">
            No comments found!
        </div>
    </div>
    @endif
    @foreach ($comments as $comment)
        <div class="card mt-4" wire:poll.5s>
            @livewire('task.single-comment', [
                'comment' => $comment,
            ], key($comment->id))
        </div>
    @endforeach
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
