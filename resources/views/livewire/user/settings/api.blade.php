<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Personal Access Token</span>
            <div>API Token generated that can be used to access the Taskord API.</div>
        </div>
        <div class="card-body">
            <x-alert />
            <form wire:submit.prevent="regenerateToken">
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
                    <span wire:target="regenerateToken" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
                </button>
            </form>
        </div>
    </div>
</div>
