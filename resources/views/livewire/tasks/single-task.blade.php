<li class="list-group-item pt-2 pb-2">
    <div>
        <input
            class="form-check-input task-checkbox"
            id="task-{{ $task->id }}"
            type="checkbox"
            wire:click="checkTask"
            unchecked
        />
        <label for="task-{{ $task->id }}" class="ms-1 task-font d-inline">
            {!! Purify::clean(Helper::renderTask($task->task)) !!}
            @if ($task->type === 'product')
            <span class="small text-secondary">
                on
                <img loading=lazy class="rounded mb-1 ms-1 avatar-15" src="{{ Helper::getCDNImage($task->product->avatar, 80) }}" height="15" width="15" alt="{{ $task->product->slug }}'s avatar" />
                <a class="text-secondary" href="{{ route('product.done', ['slug' => $task->product->slug]) }}">
                    {{ $task->product->name }}
                </a>
            </span>
            @endif
        </label>
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
        <span class="d-flex small float-end ms-auto">
            <span class="fw-bold me-2">
                @if ($task->due_at)
                    {!! Helper::renderDueDate($task->due_at) !!}
                @endif
            </span>
            @if (Auth::id() === $task->user->id)
                @if ($confirming === $task->id)
                <button type="button" class="btn btn-task btn-danger" wire:click="deleteTask" wire:loading.attr="disabled" aria-label="Confirm Delete">
                    Are you sure?
                </button>
                @else
                <button type="button" class="btn btn-task btn-outline-danger" wire:click="confirmDelete" wire:loading.attr="disabled" aria-label="Delete">
                    <x-heroicon-o-trash class="heroicon-small me-0" />
                </button>
                @endif
            @endif
        </span>
    </div>
</li>
