<div>
    <div class="card mb-3">
        <div class="card-body">
            <x-alert />
            @error('task')
                <div class="alert alert-danger alert-dismissible fade show mt-2">
                    <button type="button" class="btn-close small" data-dismiss="alert"></button>
                    <i class="fa fa-exclamation-triangle mr-1"></i>
                    {{ $message }}
                </div>
            @enderror
            <form wire:submit.prevent="submit">
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input
                            class="form-check-input task-checkbox"
                            type="checkbox"
                            wire:click="checkState"
                            wire:offline.attr="disabled"
                            {{ Auth::check() && Auth::user()->checkState ? 'checked' : 'unchecked' }}
                        >
                    </div>
                    <input type="text" class="form-control mentionInput" placeholder="Add a Task" wire:model.lazy="task" autocomplete="off">
                </div>
                <div class="d-flex justify-content-between">
                <div class="form-file form-file-sm col-6 col-lg-3">
                    <input type="file" wire:model="images" class="form-file-input" accept="image/*" multiple>
                    <label class="form-file-label">
                        <span class="form-file-text">Choose files...</span>
                        <span class="form-file-button">Browse</span>
                    </label>
                </div>
                @auth
                @if (!Auth::user()->checkState)
                <div class="form-group ml-auto mr-2 d-none d-sm-block">
                    <input class="form-control form-control-sm" wire:model.defer="due_at" type="date" placeholder="Due date" min="{{ Carbon::today()->format('Y-m-d') }}" />
                </div>
                @endif
                @endauth
                <button wire:loading.attr="disabled" wire:offline.attr="disabled" class="btn btn-sm btn-primary" type="submit">
                    <i class="fa fa-plus mr-1"></i>
                    Add Task
                    <span wire:target="submit" wire:loading class="spinner-border spinner-border-mini ml-2" role="status"></span>
                </button>
                </div>
                <div wire:loading wire:target="image">
                    <div class="spinner-border spinner-border-sm mt-4" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                </div>
                @error('images.*')
                <div class="text-danger font-weight-bold mt-3">{{ $message }}</div>
                @enderror
            </form>
        </div>
    </div>
</div>
