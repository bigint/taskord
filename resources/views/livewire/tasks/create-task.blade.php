<div>
    <div class="card mb-3">
        <div class="card-body">
            @error('task')
                <div class="alert alert-danger alert-dismissible fade show mt-2">
                    <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
                    <x-heroicon-o-exclamation class="heroicon" />
                    {{ $message }}
                </div>
            @enderror
            <form wire:submit.prevent="submit">
                <div class="mb-3">
                    <input type="text" class="form-control mentionInput" placeholder="Add a Task" wire:model.lazy="task"
                        autocomplete="off" aria-label="Task Input">
                </div>
                <div class="d-flex justify-content-between">
                    <div class="form-file form-file-sm col-6 col-lg-3">
                        <input class="form-control form-control-sm" wire:model="images" accept="image/*" type="file"
                            aria-label="Upload Images" multiple>
                    </div>
                    <div class="ms-auto me-2 d-none d-sm-block">
                        <input class="form-control form-control-sm" wire:model.defer="dueAt" type="date"
                            placeholder="Due date" min="{{ carbon('today')->format('Y-m-d') }}" />
                    </div>
                    <button class="btn btn-sm btn-outline-primary rounded-pill d-flex align-items-center" type="submit">
                        <x-heroicon-o-plus class="heroicon heroicon-15px" />
                        <span>Add Task</span>
                    </button>
                </div>
                <div wire:loading wire:target="images">
                    <div class="spinner-border spinner-border-sm mt-4" role="status"></div>
                </div>
                @if ($images)
                    <div class="gallery">
                        @foreach ($images ?? [] as $image)
                            <div>
                                <img loading=lazy
                                    class="{{ count($images) === 1 ? 'w-50' : 'gallery' }} img-fluid mt-3 rounded"
                                    src="{{ $image->temporaryUrl() }}" />
                            </div>
                        @endforeach
                    </div>
                @endif
                @error('images')
                    <div class="text-danger fw-bold mt-3">{{ $message }}</div>
                @enderror
            </form>
        </div>
    </div>
</div>
