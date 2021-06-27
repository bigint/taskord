<div>
    @if ($data['body_type'] === 'task')
        @if ($body)
            <div class="mt-2 text-secondary">
                mentioned you in a
                <a class="fw-bold" href="{{ route('task', ['id' => $body->id]) }}">
                    task
                </a>
            </div>
            <div class="card mt-3">
                <span class="p-3">
                    <livewire:task.single-task :task="$body" :showComments="false" :wire:key="$body->id" />
                </span>
            </div>
        @else
            <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
        @endif
    @elseif ($data['body_type'] === 'comment')
        @if ($body and $body->task)
            <div class="mt-2 text-secondary">
                mentioned you in a
                <a class="fw-bold"
                    href="{{ route('comment', ['taskId' => $body->task->id, 'commentId' => $body->id]) }}">
                    comment
                </a>
            </div>
            <div class="mt-3">
                <livewire:comment.single-comment :comment="$body" :wire:key="$body->id" />
            </div>
        @else
            <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
        @endif
    @elseif ($data['body_type'] === 'comment_reply')
        @if ($body and $body->comment)
            <div class="mt-2 text-secondary">
                mentioned you in a
                <a class="fw-bold"
                    href="{{ route('comment', ['taskId' => $body->comment->task->id, 'commentId' => $body->comment->id]) }}#reply_{{ $body->id }}">
                    reply
                </a>
            </div>
            <div class="card mt-3">
                <div class="card-body body-font">
                    {!! markdown($body->reply) !!}
                </div>
            </div>
        @else
            <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
        @endif
    @elseif ($data['body_type'] === 'answer')
        @if ($body and $body->question)
            <div class="mt-2 text-secondary">
                mentioned you in an
                <a class="fw-bold" href="{{ route('question.question', ['slug' => $body->question->slug]) }}">
                    answer
                </a>
            </div>
            <div class="mb-3">
                <livewire:answer.single-answer :answer="$body" :wire:key="$body->id" />
            </div>
        @else
            <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
        @endif
    @endif
</div>
