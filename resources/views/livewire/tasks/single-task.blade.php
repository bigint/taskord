<li class="list-group-item pt-2 pb-2">
    <x-alert />
    <div>
        <input
            class="form-check-input"
            type="checkbox"
            wire:click="checkTask"
            unchecked
        />
        <span class="ml-1 task-font">
            {!! Purify::clean(Helper::renderTask($task->task)) !!}
            @if ($task->type === 'product')
            <span class="small text-black-50">
                on
                <img class="rounded mb-1 ml-1 avatar-15" src="{{ $task->product->avatar }}" />
                <a class="text-black-50" href="{{ route('product.done', ['slug' => $task->product->slug]) }}">
                    {{ $task->product->name }}
                </a>
            </span>
            @endif
        </span>
        @if ($task->image)
        <div>
            <img class="img-fluid border mt-3 rounded w-50" src="{{ asset('storage/' . $task->image) }}" />
        </div>
        @endif
        <span class="d-flex small float-right ml-auto">
            <span class="font-weight-bold mr-2">
                @if ($task->due_at)
                    {!! Helper::dueDate($task->due_at) !!}
                @endif
            </span>
            @if (Auth::id() === $task->user->id)
                @if ($confirming === $task->id)
                <button type="button" class="btn btn-task btn-danger" wire:click="deleteTask" wire:loading.attr="disabled">
                    Are you sure?
                    <span wire:target="deleteTask" wire:loading class="spinner-border spinner-border-mini ml-2" role="status"></span>
                </button>
                @else
                <button type="button" class="btn btn-task btn-outline-danger" wire:click="confirmDelete" wire:loading.attr="disabled">
                    {{ Emoji::wastebasket() }}
                </button>
                @endif
            @endif
        </span>
    </div>
</li>
