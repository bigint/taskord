<div>
    <div class="card mb-4">
        <div class="card-header h6 pt-3 pb-3">
            <div class="h5">
                Today
            </div>
            <span class="font-weight-bold">{{ $tasks->count() }}</span>
            Pending Tasks
        </div>
        <ul class="list-group list-group-flush">
            @if (count($tasks) === 0)
            <div class="card-body text-center">
                <i class="fa fa-3x fa-check-square mb-3 text-primary"></i>
                <div class="h5">
                    Enjoy your day
                </div>
            </div>
            @endif
            @foreach($tasks as $task)
                @livewire('tasks.single-task', [
                    'task' => $task
                ], key($task->id))
            @endforeach
        </ul>
    </div>
</div>
