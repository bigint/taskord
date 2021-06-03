<div>
    @if ($task)
        <div class="mt-2 text-secondary">
            liked your
            <a class="fw-bold" href="{{ route('task', ['id' => $task->id]) }}">
                task
            </a>
        </div>
        <div class="card mt-3">
            <span class="p-3">
                <livewire:task.single-task :task="$task" :showComments="false" :wire:key="$task->id" />
            </span>
        </div>
    @else
        <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
