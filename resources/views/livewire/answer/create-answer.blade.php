<div>
    <div class="card mt-4">
        <div class="card-body">
            <x-alert />
            @error('answer')
                <div class="alert alert-danger alert-dismissible fade show mt-2">
                    <button type="button" class="btn-close small" data-dismiss="alert"></button>
                    <i class="fa fa-exclamation-triangle me-1"></i>
                    {{ $message }}
                </div>
            @enderror
            <div class="mb-2">
                <textarea placeholder="Add a answer" class="form-control mentionInput" rows="3" wire:model.lazy="answer"></textarea>
            </div>
            <button class="btn btn-sm btn-primary float-right" type="submit" wire:click="submit">
                <i class="fa fa-plus me-1"></i>
                Add answer
                <span wire:target="submit" wire:loading class="spinner-border spinner-border-mini ms-2" role="status"></span>
            </button>
        </div>
    </div>
</div>
