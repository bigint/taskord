<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3">
            <span class="h5">Personal Access Token</span>
            <div>API Token generated that can be used to access the Taskord API.</div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="regenerateToken">
                <div class="mb-3">
                    <label class="form-label">Personal Access Token</label>
                    <div class="input-group">
                        <input type="text" id="personal-access-token"
                            class="form-control @error('token') is-invalid @enderror" value="{{ $user->api_token }}"
                            readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary js-clipboard" type="button" title="Copy"
                                data-bs-toggle="tooltip" data-for="#personal-access-token">
                                <x-heroicon-o-clipboard-copy class="heroicon heroicon-18px">
                                </x-heroicon-o-clipboard-copy>
                            </button>
                        </div>
                    </div>
                    @error('token')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-outline-primary rounded-pill">
                    Regenerate
                </button>
            </form>
        </div>
    </div>
</div>
