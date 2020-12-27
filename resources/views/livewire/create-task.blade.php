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
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <label for="checkState" class="form-label d-none">Upload Images</label>
                        <input
                            class="form-check-input task-checkbox"
                            id="checkState"
                            type="checkbox"
                            wire:click="checkState"
                            wire:loading.attr="disabled"
                            wire:offline.attr="disabled"
                            {{ Auth::check() && Auth::user()->checkState ? 'checked' : 'unchecked' }}
                        >
                    </div>
                    <input type="text" class="form-control mentionInput" placeholder="Add a Task" wire:model.lazy="task" autocomplete="off">
                </div>
                <div class="d-flex justify-content-between">
                <div class="form-file form-file-sm col-6 col-lg-3">
                    <label for="uploadTaskImages" class="form-label d-none">Upload Images</label>
                    <input class="form-control form-control-sm" id="uploadTaskImages" wire:model="images" accept="image/*" type="file" multiple>
                </div>
                @auth
                @if (!Auth::user()->checkState)
                <div class="ms-auto me-2 d-none d-sm-block">
                    <input class="form-control form-control-sm" wire:model.defer="due_at" type="date" placeholder="Due date" min="{{ Carbon::today()->format('Y-m-d') }}" />
                </div>
                @endif
                @endauth
                <button wire:loading.attr="disabled" wire:offline.attr="disabled" class="btn btn-sm btn-primary" type="submit">
                    <x-heroicon-o-plus class="heroicon" />
                    Add Task
                </button>
                </div>
                <div wire:loading wire:target="images">
                    <div class="spinner-border spinner-border-sm mt-4" role="status"></div>
                </div>
                @if ($images)
                    <div class="gallery">
                    @foreach ($images ?? [] as $image)
                    <div>
                        <img loading=lazy class="{{ count($images) === 1 ? 'w-50' : 'gallery' }} img-fluid border mt-3 rounded" src="{{ $image->temporaryUrl() }}" />
                    </div>
                    @endforeach
                    </div>
                @endif
                @error('images.*')
                <div class="text-danger fw-bold mt-3">{{ $message }}</div>
                @enderror
            </form>
        </div>
    </div>
</div>
