<div class="col-md-8">
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Personal Access Token</span>
            <div>WIP.</div>
        </div>
        <div class="card-body">
            <x-alert />
            <form wire:submit.prevent="updateAccount">
                <div class="mb-3">
                    <label class="form-label">Personal Access Token</label>
                    <input type="text" class="form-control @error('token') is-invalid @enderror" value="{{ $user->api_token }}" disabled>
                    @error('token')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    Regenerate
                    <span wire:target="updateAccount" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
                </button>
            </form>
        </div>
    </div>
</div>
