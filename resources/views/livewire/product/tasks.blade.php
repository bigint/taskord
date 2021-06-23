<div wire:init="loadTasks">
    @if (!$readyToLoad)
        <div class="card-body text-center mt-3 mb-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading tasks...
            </div>
        </div>
    @endif
    @if ($readyToLoad and count($tasks) === 0)
        @php
            if ($type === 'product.done') {
                $message = 'No completed todos found';
            } else {
                $message = 'All Done';
            }
        @endphp
        <div class="card-body text-center mt-3 mb-3">
            <x-heroicon-o-check-circle class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                {{ $message }}
            </div>
        </div>
    @endif
    @if ($page === 1)
        <ul class="list-group">
    @endif
    @foreach ($tasks as $task)
        <li class="list-group-item p-3 {{ ($loop->index == 0 and $page > 1) ? 'border-top-0 rounded-0' : '' }}">
            <livewire:task.single-task :task="$task" :wire:key="$task->id" />
        </li>
    @endforeach
    @if ($readyToLoad and $tasks->hasMorePages())
        <livewire:product.load-more :type="$type" :product="$task->product" :page="$page" />
    @endif
    @if ($page === 1)
        </ul>
    @endif
</div>
