<div>
    <div class="h5">
        Tasks
    </div>
    @if (count($tasks) === 0)
    @include('components.empty', [
        'icon' => 'check-square',
        'text' => 'No tasks made!',
    ])
    @endif
    @if ($page === 1)
    <ul class="list-group">
    @endif
    @foreach ($tasks as $task)
    <li class="list-group-item p-3">
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
