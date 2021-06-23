<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3">
            <span class="h5">Change Password</span>
            <div>Update your account password.</div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="updatePassword">
                <div class="mb-3">
                    <label class="form-label">Existing Password</label>
                    <input type="password" class="form-control @error('currentPassword') is-invalid @enderror"
                        wire:model.defer="currentPassword">
                    @error('currentPassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" class="form-control @error('newPassword') is-invalid @enderror"
                        wire:model="newPassword">
                    @error('newPassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control @error('confirmPassword') is-invalid @enderror"
                        wire:model="confirmPassword">
                    @error('confirmPassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-outline-primary rounded-pill">Save</button>
            </form>
        </div>
    </div>
</div>
