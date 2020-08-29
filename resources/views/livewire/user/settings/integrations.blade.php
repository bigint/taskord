<div class="col-md-8">
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Integrations</span>
            <div>TODO</div>
        </div>
        <div class="card-body">
            <span class="h5">Create Webhook</span>
            <form wire:submit.prevent="submit">
                <div class="mb-3 mt-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="Webhook Name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    Create Hook
                    <span wire:target="submit" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
                </button>
            </form>
            @if (session()->has('created'))
                <div class="mt-2">
                    {{ session('created')->name }}
                </div>
            @endif
        </div>
    </div>
</div>
