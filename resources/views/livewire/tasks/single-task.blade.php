<li class="list-group-item pt-2 pb-2">
    @include('components.alert')
    <div>
        <input
            class="form-check-input"
            type="checkbox"
            wire:click="checkTask"
            unchecked
        />
        <span class="ml-1 task-font">
            {!! Purify::clean(Helper::renderTask($task->task)) !!}
        </span>
        <span class="d-flex small float-right ml-auto">
            <a class="mr-3 text-black-50" href="{{ route('task', ['id' => $task->id]) }}">
                {{ !$task->done_at ? Carbon::parse($task->created_at)->diffForHumans() : Carbon::parse($task->done_at)->diffForHumans() }}
            </a>
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
        @if ($task->image)
        <div>
            <img class="img-fluid border mt-3 rounded" src="{{ asset('storage/' . $task->image) }}" />
        </div>
        @endif
    </div>
</li>
