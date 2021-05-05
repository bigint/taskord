<div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="newTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                @if (!auth()->user()->isFlagged)
                    @livewire('create-task', [
                        'show_latest_task' => true
                    ])
                @else
                <div class="text-center">
                    <div class="alert alert-danger mb-0" role="alert">
                        You can't create new task, because your account has been flagged 😢
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
