<div id="task-list">
    @if (count($tasks) === 0)
    @include('components.empty', [
        'icon' => 'check-square',
        'text' => 'No tasks made!',
    ])
    @endif
    @foreach ($tasks as $key => $groupedTask)
        @if (Carbon::now()->format('M d Y') === Carbon::parse($key)->format('M d Y'))
        <div class="mb-2">
            <span class="h5 font-weight-bold">Today,</span>
            <span class="h5">{{ Carbon::parse($key)->format('M d') }}</span>
        </div>
        @elseif (Carbon::now()->subDays(1)->format('M d Y') === Carbon::parse($key)->format('M d Y'))
        <div class="mb-2">
            <span class="h5 font-weight-bold">Yesterday,</span>
            <span class="h5">{{ Carbon::parse($key)->format('M d') }}</span>
        </div>
        @else
        <div class="mb-2">
            <span class="h5 font-weight-bold">{{ Carbon::parse($key)->format('M d,') }}</span>
            <span class="h5">{{ Carbon::parse($key)->format('Y') }}</span>
        </div>
        @endif
        <div class="card mb-4" wire:poll.5s>
            <ul class="list-group list-group-flush">
                @foreach ($groupedTask as $task)
                    @livewire('task.single-task', [
                        'task' => $task
                    ], key($task->id))
                @endforeach
            </ul>
        </div>
    @endforeach
    @if ($tasks->hasMorePages())
        @livewire('home.load-more', [
            'page' => $page,
            'perPage' => $perPage
        ])
    @endif
</div>
