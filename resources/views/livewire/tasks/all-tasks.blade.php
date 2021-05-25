<div wire:init="loadAllTasks">
    <div class="card mb-4">
        <div class="card-header h6 py-3">
            <div class="h5">
                All Tasks
            </div>
            <span class="fw-bold">{{ $ready_to_load ? auth()->user()->tasks()->whereDone(false)->count('id') : '···' }}</span>
            Pending Tasks
        </div>
        <ul class="list-group list-group-flush">
            @if (!$ready_to_load)
                <div class="card-body text-center mt-3 mb-3">
                    <div class="spinner-border taskord-spinner text-secondary" role="status"></div>
                </div>
            @endif
            @if ($ready_to_load and count($tasks) === 0)
                <div class="card-body text-center mt-3 mb-3">
                    <x-heroicon-o-check-circle class="heroicon heroicon-60px text-primary mb-2" />
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
            {{ $ready_to_load ? $tasks->links() : '' }}
        </ul>
    </div>
</div>
