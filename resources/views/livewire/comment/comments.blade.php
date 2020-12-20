<div>
    @if ($comments->count('id') === 0)
    <div class="card-body text-center mt-3 mb-3">
        <x-heroicon-o-chat-alt-2 class="heroicon-4x text-primary mb-2" />
        <div class="h4">
            No comments found!
        </div>
    </div>
    @endif
    <ul class="list-group mt-4">
    @foreach ($comments as $comment)
        @livewire('comment.single-comment', [
            'comment' => $comment,
        ], key($comment->id))
    @endforeach
    </ul>
    <div class="mt-4">
        @if ($comments->hasMorePages())
            @livewire('comment.load-more', [
                'task' => $task,
                'page' => $page,
                'perPage' => $perPage
            ])
        @endif
    </div>
</div>
