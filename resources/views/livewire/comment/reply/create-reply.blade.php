<div class="card {{ $comment->replies()->count('id') > 0 ? '' : 'mt-3' }}">
    <div class="card-body">
        @error('reply')
            <div class="alert alert-danger alert-dismissible fade show mt-2">
                <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
                <x-heroicon-o-exclamation class="heroicon" />
                {{ $message }}
            </div>
        @enderror
        <div class="mb-2">
            <x:markdown-toolbar htmlFor="reply-box-{{ $comment->id }}" />
            <textarea placeholder="Add a reply" id="reply-box-{{ $comment->id }}" class="form-control mentionInput mt-3" rows="3" wire:model.lazy="reply"></textarea>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <a class="small fw-bold text-secondary" href="https://guides.github.com/features/mastering-markdown" target="_blank">
                <x-heroicon-o-pencil-alt class="heroicon" />
                Markdown is supported
                 <x:labels.beta />
            </a>
            <button wire:loading.attr="disabled" wire:target="submit" class="btn btn-sm btn-outline-primary rounded-pill" type="submit" wire:click="submit">
                <x-heroicon-o-plus class="heroicon heroicon-15px" />
                Reply
            </button>
        </div>
    </div>
</div>
