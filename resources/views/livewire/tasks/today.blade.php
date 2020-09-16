<div>
    <div class="card mb-4">
        <div class="card-header h6 pt-3 pb-3">
            <div class="h5">
                Today
            </div>
            <span class="font-weight-bold">{{ $tasks->count('id') }}</span>
            Pending Tasks
        </div>
        <ul class="list-group list-group-flush">
            @if (count($tasks) === 0)
            <x-empty icon="check-square" text="Enjoy your day"/>
            @endif
            @foreach($tasks as $task)
                @livewire('tasks.single-task', [
                    'task' => $task
                ], key($task->id))
            @endforeach
        </ul>
    </div>
</div>
