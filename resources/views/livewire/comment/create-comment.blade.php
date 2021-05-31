<div class="card">
    <div class="card-body">
        @error('comment')
            <div class="alert alert-danger alert-dismissible fade show mt-2">
                <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
                <x-heroicon-o-exclamation class="heroicon" />
                {{ $message }}
            </div>
        @enderror
        <div class="mb-2">
            <x:markdown-toolbar htmlFor="comment-box" />
            <textarea placeholder="Add a comment" id="comment-box" class="form-control mentionInput mt-2" rows="3" wire:model.defer="comment"></textarea>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="small fw-bold text-secondary">
                <x-heroicon-o-pencil-alt class="heroicon" />
                Markdown is supported
                 <x:labels.beta />
            </div>
            <button wire:loading.attr="disabled" wire:target="submit" class="btn btn-sm btn-primary" type="submit" wire:click="submit">
                <x-heroicon-o-plus class="heroicon" />
                Add Comment
            </button>
        </div>
    </div>
</div>
