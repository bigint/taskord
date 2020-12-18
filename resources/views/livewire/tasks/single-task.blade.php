<li class="list-group-item pt-2 pb-2">
    <x-alert />
    <div>
        <input
            class="form-check-input task-checkbox"
            type="checkbox"
            wire:click="checkTask"
            unchecked
        />
        <span class="ms-1 task-font">
            {!! Purify::clean(Helper::renderTask($task->task)) !!}
            @if ($task->type === 'product')
            <span class="small text-black-50">
                on
                <img class="rounded mb-1 ms-1 avatar-15" src="{{ $task->product->avatar }}" alt="{{ $task->product->slug }}'s avatar" />
                <a class="text-black-50" href="{{ route('product.done', ['slug' => $task->product->slug]) }}">
                    {{ $task->product->name }}
                </a>
            </span>
            @endif
        </span>
        @if ($task->images)
        <div class="gallery mb-3">
        @foreach ($task->images ?? [] as $image)
        <div>
            <a href="{{ asset('storage/' . $image) }}" data-lightbox="{{ $image }}" data-title="Image by {{ '@'.$task->user->username }}">
                <img class="{{ count($task->images) === 1 ? 'w-50' : 'gallery' }} img-fluid border mt-3 rounded" src="{{ asset('storage/' . $image) }}" alt="{{ asset('storage/' . $image) }}" />
            </a>
        </div>
        @endforeach
        </div>
        @endif
        <span class="d-flex small float-end ms-auto">
            <span class="fw-bold me-2">
                @if ($task->due_at)
                    {!! Helper::dueDate($task->due_at) !!}
                @endif
            </span>
            @if (Auth::id() === $task->user->id)
                @if ($confirming === $task->id)
                <button type="button" class="btn btn-task btn-danger" wire:click="deleteTask" wire:loading.attr="disabled">
                    Are you sure?
                    <span wire:target="deleteTask" wire:loading class="spinner-border spinner-border-mini ms-2" role="status"></span>
                </button>
                @else
                <button type="button" class="btn btn-task btn-outline-danger" wire:click="confirmDelete" wire:loading.attr="disabled">
                    🗑
                </button>
                @endif
            @endif
        </span>
    </div>
</li>
