<div wire:init="loadComments">
    @if (!$readyToLoad)
        <div class="card-body text-center mt-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading comments...
            </div>
        </div>
    @endif
    @if ($readyToLoad and count($comments) === 0)
        <div class="card-body text-center mt-3 mb-3">
            <x-heroicon-o-chat-alt-2 class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                No comments found!
            </div>
        </div>
    @endif
    <ul class="list-group mt-4">
        @foreach ($comments as $comment)
            <div class="mb-3">
                <livewire:comment.single-comment :comment="$comment" :wire:key="$comment->id" />
            </div>
        @endforeach
    </ul>
    <div class="mt-4">
        @if ($readyToLoad and $comments->hasMorePages())
            <livewire:comment.load-more :task="$task" :page="$page" :perPage="$perPage" />
        @endif
    </div>
</div>
