<div>
    <div class="card mb-3">
        <div class="card-body">
            @include('components.alert')
            @error('task')
                <div class="alert alert-danger alert-dismissible fade show mt-2">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <i class="fa fa-exclamation-triangle mr-1"></i>
                    {{ $message }}
                </div>
            @enderror
            <form wire:submit.prevent="submit">
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            wire:click="checkState"
                            {{ Auth::check() && Auth::user()->checkState ? 'checked' : 'unchecked' }}
                        >
                    </div>
                    <input type="text" class="form-control" placeholder="Add a Task" wire:model.debounce.5s="task">
                </div>
                <div class="d-flex justify-content-between">
                <div class="form-file form-file-sm w-25">
                    <input type="file" wire:model="image" class="form-file-input">
                    <label class="form-file-label">
                        <span class="form-file-text">Choose file...</span>
                        <span class="form-file-button">Browse</span>
                    </label>
                </div>
                <button wire:loading.attr="disabled" class="btn btn-sm btn-primary" type="submit">
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
                @error('image')
                <div class="text-danger font-weight-bold mt-3">{{ $message }}</div>
                @else
                @if ($image)
                <img class="img-fluid border mt-3 rounded" src="{{ $image->temporaryUrl() }}">
                @endif
                @enderror
            </form>
        </div>
    </div>
</div>
