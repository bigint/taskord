<form wire:target="submit" wire:submit.prevent="submit">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label fw-bold">Firstname</label>
            <input type="text" class="form-control" placeholder="John" wire:model.defer="firstname">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold">Lastname</label>
            <input type="text" class="form-control" placeholder="Doe" wire:model.defer="lastname">
        </div>
    </div>
    <div class="mt-3">
        <label class="form-label fw-bold">Username</label>
        <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="johndoe" wire:model="username">
        @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mt-3">
        <label class="form-label fw-bold">Bio</label>
        <textarea class="form-control" rows="4" placeholder="Bio" wire:model.defer="bio"></textarea>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary px-5 mt-4 fw-bold">
            Update the profile
        </button>
    </div>
</form>
