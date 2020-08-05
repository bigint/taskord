<div class="card border-warning mb-4">
    <div class="card-header font-weight-bold">
        Moderator
    </div>
    <div class="card-body">
        <div class="text-info h5 mb-3">
            <i class="fa fa-flag-checkered mr-1"></i>
            Flags
        </div>
        <div class="mb-2 mt-3">
            <input wire:click="enrollBeta" id="enrollBeta" class="form-check-input" type="checkbox" {{ $user->isBeta ? 'checked' : '' }}>
            <label for="enrollBeta" class="ml-1">Enroll to Beta</label >
            <span wire:loading wire:target="enrollBeta" class="small ml-2 text-success font-weight-bold">Enrolling...</span>
        </div>
        <div class="mb-2">
            <input wire:click="enrollStaff" id="enrollStaff" class="form-check-input" type="checkbox" {{ $user->isStaff ? 'checked' : '' }}>
            <label for="enrollStaff" class="ml-1">Enroll to Staff</label>
            <span wire:loading wire:target="enrollStaff" class="small ml-2 text-success font-weight-bold">Enrolling...</span>
        </div>
        <div class="mb-2">
            <input wire:click="enrollPatron" id="enrollPatron" class="form-check-input" type="checkbox" {{ $user->isPatron ? 'checked' : '' }}>
            <label for="enrollPatron" class="ml-1">Enroll to Patron</label>
            <span wire:loading wire:target="enrollPatron" class="small ml-2 text-success font-weight-bold">Enrolling...</span>
        </div>
        <div class="mb-2">
            <input wire:click="enrollDarkMode" id="enrollDarkMode" class="form-check-input" type="checkbox" {{ $user->darkMode ? 'checked' : '' }}>
            <label for="enrollDarkMode" class="ml-1">Enable Dark Mode</label>
            <span wire:loading wire:target="enrollDarkMode" class="small ml-2 text-success font-weight-bold">Enrolling...</span>
        </div>
        <div class="mb-3">
            <input wire:click="enrollDeveloper" id="enrollDeveloper" class="form-check-input" type="checkbox" {{ $user->isDeveloper ? 'checked' : '' }}>
            <label for="enrollDeveloper" class="ml-1">Enroll to Contributor</label>
            <span wire:loading wire:target="enrollDeveloper" class="small ml-2 text-success font-weight-bold">Enrolling...</span>
        </div>
        <div>
            <button wire:click="masquerade" class="btn btn-sm btn-warning font-weight-bold">
                <i class="fa fa-user-secret mr-1"></i>
                Masquerade
            </button>
            <span wire:loading wire:target="Masquerade" class="small ml-2 text-danger font-weight-bold">masquerading...</span>
        </div>
        @if (!$user->isStaff)
        <hr>
        <div class="text-danger h5 mb-3">
            <i class="fa fa-user-ninja mr-1"></i>
            Danger Zone
        </div>
        <div class="mt-2">
            <input wire:click="flagUser" id="flagUser" class="form-check-input" type="checkbox" {{ $user->isFlagged ? 'checked' : '' }}>
            <label for="flagUser" class="ml-1 text-danger font-weight-bold">Flag this user</label>
            <span wire:loading wire:target="flagUser" class="small ml-2 text-danger font-weight-bold">Flagging...</span>
        </div>
        <div class="mt-3">
            <button wire:click="deleteUser" class="btn btn-sm btn-danger font-weight-bold">
                <i class="fa fa-trash mr-1"></i>
                Delete this user
            </button>
            <span wire:loading wire:target="deleteUser" class="small ml-2 text-danger font-weight-bold">Deleting...</span>
        </div>
        @endif
    </div>
</div>
