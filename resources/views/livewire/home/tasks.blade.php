<div>
    @if (count($tasks) === 0)
    <x-empty icon="check-square" text="No tasks made!" />
    @endif
    @if ($page === 1)
    <ul class="list-group">
    @endif
    @foreach ($tasks as $task)
    <li class="list-group-item p-3 {{($loop->index == 0 and $page > 1) ? "border-top-0 rounded-0" : ""}}">
        @livewire('task.single-task', [
            'task' => $task,
        ], key($task->id))
    </li>
    @endforeach
    @if ($tasks->hasMorePages())
        @livewire('home.load-more', [
            'page' => $page,
        ])
    @endif
    @if ($page === 1)
    </ul>
    @endif
</div>
