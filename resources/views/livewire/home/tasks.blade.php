<div>
    <div class="mb-3">
        <span class="h5">
            Tasks
        </span>
        @auth
        <span class="float-right">
            <input wire:click="onlyFollowingsTasks" id="onlyFollowingsTasks" class="form-check-input" type="checkbox" {{ Auth::user()->onlyFollowingsTasks ? 'checked' : '' }}>
            <label for="onlyFollowingsTasks" class="ml-1">Show only following</label>
            <span wire:loading wire:target="onlyFollowingsTasks" class="small ml-2 spinner-border spinner-border-sm text-primary"></span>
        </span>
        @endauth
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
