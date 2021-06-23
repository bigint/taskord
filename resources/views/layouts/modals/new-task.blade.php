<div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="newTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="px-4 pt-4 d-flex align-items-center justify-content-between">
                <h5 class="modal-title text-dark d-flex align-items-center" id="newTaskModalLabel">
                    <x-heroicon-o-check-circle class="heroicon heroicon-20px" />
                    <span class="ms-1 me-2">New task</span>
                    <x:labels.beta />
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                @if (!auth()->user()->spammy)
                    @livewire('create-task', ['showLatestTask' => true])
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
