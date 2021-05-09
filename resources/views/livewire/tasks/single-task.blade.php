<li class="list-group-item pt-2 pb-2">
    <div class="form-check">
        <input
            class="form-check-input task-check"
            id="task-{{ $task->id }}"
            type="checkbox"
            wire:click="checkTask"
            {{ $task->done ? "checked" : "unchecked" }}
        />
        <label class="task-font text-dark ms-2">
            <a class="text-dark" href="{{ route('task', ['id' => $task->id]) }}">
                {!! Purifier::clean(Helper::renderTask($task->task)) !!}
            </a>
            @if ($task->type === 'product')
            <span class="small text-secondary">
                <img loading=lazy class="rounded mb-1 ms-1 avatar-15" src="{{ Helper::getCDNImage($task->product->avatar, 80) }}" height="15" width="15" alt="{{ $task->product->slug }}'s avatar" />
                <a class="text-secondary" href="{{ route('product.done', ['slug' => $task->product->slug]) }}">
                    {{ $task->product->name }}
                </a>
            </span>
            @endif
        </label>
    </div>
    @if ($task->images)
    <div class="gallery mb-3">
    @foreach ($task->images ?? [] as $image)
    <div>
        <a href="{{ asset('storage/' . $image) }}" target="_blank">
            <img loading=lazy class="gallery img-fluid border mt-3 rounded" src="{{ Helper::getCDNImage(asset('storage/' . $image), 500) }}" alt="{{ asset('storage/' . $image) }}" />
        </a>
    </div>
    @endforeach
    </div>
    @endif
    @if ($task->milestone)
    <div class="my-1" title="Milestone">
        <a class="text-secondary" href="{{ route('milestones.milestone', ['milestone' => $task->milestone]) }}">
            <x-heroicon-o-truck class="heroicon me-1" />
            <span>{{ $task->milestone->name }}</span>
        </a>
    </div>
    @endif
    <div class="mt-2">
        @if ($task->due_at)
        <div class="fw-bold me-2 mb-2 small">
            {!! Helper::renderDueDate($task->due_at) !!}
        </div>
        @endif
        @if (auth()->user()->id === $task->user->id)
            @livewire('task.select-milestone', [
                'task' => $task
            ])
            @if ($show_delete)
            <button
                type="button"
                class="btn btn-task btn-outline-danger my-1"
                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                wire:click="deleteTask"
                wire:loading.attr="disabled"
                wire:offline.attr="disabled"
                aria-label="Delete"
            >
                <x-heroicon-o-trash class="heroicon-small me-0 text-secondary" />
            </button>
            @else
            <a href="{{ route('task', ['id' => $task->id]) }}" class="btn btn-task btn-outline-success me-1" target="_blank" aria-label="Open task">
                <x-heroicon-o-external-link class="heroicon-small me-0" />
                Open task
            </a>
            @endif
        @endif
    </div>
</li>
