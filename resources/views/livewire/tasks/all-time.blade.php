<div wire:init="loadAllTimeTasks">
    <div class="card mb-4">
        <div class="card-header h6 pt-3 pb-3">
            <div class="h5">
                All Time
            </div>
            <span class="fw-bold">{{ $readyToLoad ? $tasks->count('id') : '···' }}</span>
            Pending Tasks
        </div>
        <ul class="list-group list-group-flush">
            @if (!$readyToLoad)
            <div class="card-body text-center mt-3 mb-3">
                <div class="spinner-border taskord-spinner text-secondary" role="status"></div>
            </div>
            @endif
            @if ($readyToLoad and count($tasks) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-check-circle class="heroicon-4x text-primary mb-2" />
                <div class="h4">
                    All done!
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
