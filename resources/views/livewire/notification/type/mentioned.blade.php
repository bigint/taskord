<div>
    @if ($data['body_type'] === 'task')
        @if ($body)
            <div class="mt-2">
                mentioned you in a
                <a class="fw-bold" href="{{ route('task', ['id' => $body->id]) }}">
                    task
                </a>
            </div>
            @if ($body->hidden)
            <div class="body-font fst-italic text-secondary mt-2">Task was hidden by moderator</div>
            @else
                <div class="mt-2 body-font">{!! Purifier::clean(Helper::renderTask($body->task)) !!}</div>
            @endif
        @else
            <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
        @endif
    @elseif ($data['body_type'] === 'comment')
        @if ($body and $body->task)
            <div class="mt-2">
                mentioned you in a
                <a class="fw-bold" href="{{ route('comment', ['id' => $body->task->id, 'comment_id' => $body->id]) }}">
                    comment
                </a>
            </div>
            @if ($body->hidden)
            <div class="body-font fst-italic text-secondary mt-2">Comment was hidden by moderator</div>
            @else
                <div class="mt-2 body-font">{!! markdown($body->comment) !!}</div>
            @endif
        @else
            <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
        @endif
    @elseif ($data['body_type'] === 'answer')
        @if ($body and $body->question)
            <div class="mt-2">
                mentioned you in an
                <a class="fw-bold" href="{{ route('question.question', ['id' => $body->question->id]) }}">
                    answer
                </a>
            </div>
            @if ($body->hidden)
            <div class="body-font fst-italic text-secondary mt-2">Answer was hidden by moderator</div>
            @else
                <div class="mt-2 body-font">{!! markdown($body->answer) !!}</div>
            @endif
        @else
            <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
        @endif
    @endif
</div>
