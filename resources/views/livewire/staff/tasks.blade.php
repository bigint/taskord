<div class="card" wire:init="loadTasks">
    <div class="card-header h6 py-3">
        <div class="h5">Tasks</div>
        <span class="fw-bold">{{ $readyToLoad ? $count : '···' }}</span>
        total tasks
    </div>
    <div class="table-responsive">
        @if (!$readyToLoad)
            <div class="card-body text-center mt-3">
                <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                <div class="h6">
                    Loading tasks...
                </div>
            </div>
        @else
            <table class="table text-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Status</th>
                        <th scope="col">Task</th>
                        <th scope="col">Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <th>{{ $task->id }}</th>
                            <td>
                                <a href="{{ route('user.done', ['username' => $task->user->username]) }}"
                                    target="_blank">
                                    {{ '@' . $task->user->username }}
                                </a>
                            </td>
                            <td>
                                @if ($task->done)✅@else⌛@endif
                            </td>
                            <td>
                                <a href="{{ route('task', ['id' => $task->id]) }}">
                                    {{ Str::limit($task->task, '100') }}
                                </a>
                                @if ($task->hidden)
                                    <span title="Flagged">🤢</span>
                                @endif
                            </td>
                            <td>
                                <span title="{{ $task->updated_at->format('M d, Y g:i A') }}">
                                    {{ $task->updated_at->format('M d, Y') }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    {{ $readyToLoad ? $tasks->links() : '' }}
</div>
