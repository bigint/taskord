<div class="col-lg-8">
    <div class="card">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Notifications</span>
            <div>Choose how you receive notifications.</div>
        </div>
        <div class="card-body">
            <div>
                <div class="mb-2">Get all notifications via email</div>
                <input wire:click="notificationsEmail" id="notificationsEmail" class="form-check-input" type="checkbox" {{ $user->notifications_email ? 'checked' : '' }}>
                <label for="notificationsEmail" class="ms-1">Email</label>
            </div>
            <div>
                <div class="mb-2 mt-3">Get all notifications via web</div>
                <input wire:click="notificationsWeb" id="notificationsWeb" class="form-check-input" type="checkbox" {{ $user->notifications_web ? 'checked' : '' }}>
                <label for="notificationsWeb" class="ms-1">Web</label>
            </div>
        </div>
    </div>
</div>
