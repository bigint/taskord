<div>
    @if ($task)
    <div class="mt-2">
        praised your
        <a class="fw-bold" href="{{ route('task', ['id' => $task->id]) }}">
            task
        </a>
    </div>
    @if ($task->hidden)
    <div class="body-font fst-italic text-secondary mt-2">Task was hidden by moderator</div>
    @else
        <div class="mt-2 body-font">{!! Purifier::clean(Helper::renderTask($task->task)) !!}</div>
    @endif
    @else
    <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
