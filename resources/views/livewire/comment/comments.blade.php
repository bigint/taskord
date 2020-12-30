<div wire:init="loadComments">
    @if (!$readyToLoad)
    <div class="card-body text-center mt-3">
        <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
        <div class="h6">
            Loading Comments...
        </div>
    </div>
    @endif
    @if ($readyToLoad and count($comments) === 0)
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
        @if ($readyToLoad and $comments->hasMorePages())
            @livewire('comment.load-more', [
                'task' => $task,
                'page' => $page,
                'perPage' => $perPage
            ])
        @endif
    </div>
</div>
