<div>
    @if (count($tasks) === 0)
    @include('components.empty', [
        'icon' => 'check-square',
        'text' => 'No tasks made!',
    ])
    @endif
    @foreach ($tasks as $task)
    <li class="list-group-item p-3 {{ $loop->last ? 'border-bottom-0' : '' }}">
        @livewire('task.single-task', [
            'task' => $task
        ], key($task->id))
    </li>
    @endforeach
    @if ($tasks->hasMorePages())
        @livewire('home.load-more', [
            'page' => $page,
        ])
    @endif
</div>
