<div>
    @if ($comment)
        <div class="mt-2 text-secondary">
            commented on your
            <a class="fw-bold"
                href="{{ route('comment', ['id' => $comment->task->id, 'comment_id' => $comment->id]) }}">
                task
            </a>
        </div>
        <div class="mt-3">
            <livewire:comment.single-comment :comment="$comment" :wire:key="$comment->id" />
        </div>
    @else
        <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
