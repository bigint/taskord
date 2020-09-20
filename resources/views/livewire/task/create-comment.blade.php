<div class="card">
    <div class="card-body">
        <x-alert />
        @error('comment')
            <div class="alert alert-danger alert-dismissible fade show mt-2">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <i class="fa fa-exclamation-triangle mr-1"></i>
                {{ $message }}
            </div>
        @enderror
        <div class="mb-3">
            <textarea placeholder="Add a comment" class="form-control mentionInput" rows="3" wire:model.lazy="comment"></textarea>
        </div>
        <div class="h6 font-weight-bold mb-3">
            <i class="fab fa-markdown mr-1"></i>
            Markdown is supported
        </div>
        <button class="btn btn-sm btn-primary" type="submit" wire:click="submit">
            <i class="fa fa-plus mr-1"></i>
            Add Comment
            <span wire:target="submit" wire:loading class="spinner-border spinner-border-mini ml-2" role="status"></span>
        </button>
    </div>
</div>
