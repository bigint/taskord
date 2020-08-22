<div id="task-list">
    @if (count($tasks) === 0)
    @php
    if ($type === 'product.done') {
        $message = 'No completed todos found';
    } else {
        $message = 'All Done';
    }
    @endphp
    @include('components.empty', [
        'icon' => 'check-square',
        'text' => $message,
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
        @livewire('product.load-more', [
            'type' => $type,
            'product' => $task->product,
            'page' => $page,
        ])
    @endif
    @if ($page === 1)
    </ul>
    @endif
</div>
