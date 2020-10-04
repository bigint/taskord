<div class="card border-warning mb-4">
    <div class="card-header font-weight-bold">
        Moderator
    </div>
    <div class="card-body">
        <div class="mb-1">
            <i class="fa fa-clock text-black-50 mr-1"></i>
            <span class="h6">Last Updated:</span>
            <span class="font-weight-bold">
                {{ Carbon::parse($user->updated_at)->format('M d, Y g:i A') }}
            </span>
        </div>
        <div class="mb-1">
            <i class="fa fa-envelope text-black-50 mr-1"></i>
            <span class="h6">User Email:</span>
            <a class="font-weight-bold" href="mailto:{{ $user->email }}">
                {{ $user->email }}
            </a>
            @if ($user->hasVerifiedEmail())
            <i class="fa fa-check text-success ml-1" title="Email Verified"></i>
            @else
            <i class="fa fa-times text-danger ml-1" title="Email not Verified"></i>
            @endif
        </div>
        <div class="mb-1">
            <span class="h6">
                <i class="fa fa-address-card text-black-50 mr-1"></i>
                Last login IP:
            </span>
            @if ($user->lastIP)
            <a class="font-weight-bold" href="https://ipinfo.io/{{ $user->lastIP }}" target="_blank">
                {{ $user->lastIP }}
            </a>
            @else
            <span class="font-weight-bold text-black-50">
                Not set
            </span>
            @endif
            @php
                if ($user->lastIP) {
                    $usersCount = \App\Models\User::where('lastIP', $user->lastIP)->count();
                } else {
                    $usersCount = 0;
                }
            @endphp
            @if ($usersCount > 1)
            <div class="small mt-1">
                <i class="fa fa-exclamation-triangle text-danger mr-1"></i>
                <span class="font-weight-bold">{{ $usersCount }}</span>  {{ $usersCount < 1 ? 'user' : 'users' }} associated with the same IP
            </div>
            @endif
        </div>
        <div class="mb-3">
            <span class="h6">
                <i class="fa fa-user-clock text-black-50 mr-1"></i>
                Timezone:
            </span>
            @if ($user->timezone)
            <span class="font-weight-bold">
                @php
                $hour = Carbon::now()->setTimezone($user->timezone)->format('H');
                @endphp
                {{ $user->timezone }}
                •
                <span class="text-black-50">
                    {{
                        Carbon::now()
                        ->setTimezone($user->timezone)
                        ->format('g:i A')
                    }}
                    <span style="cursor:default" class="text-body">
                        @if ($hour < 12)
                        <span title="Morning">🌄</span>
                        @elseif ($hour < 17)
                        <span title="Afternoon">☀️</span>
                        @elseif ($hour < 20)
                        <span title="Evening">🌇</span>
                        @else
                        <span title="Night">🌚</span>
                        @endif
                    </span>
                </span>
            </span>
            @else
            <span class="font-weight-bold text-black-50">
                Not set
            </span>
            @endif
        </div>
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
        <div class="mb-2">
            <input wire:click="enrollDeveloper" id="enrollDeveloper" class="form-check-input" type="checkbox" {{ $user->isDeveloper ? 'checked' : '' }}>
            <label for="enrollDeveloper" class="ml-1">Enroll to Contributor</label>
            <span wire:loading wire:target="enrollDeveloper" class="small ml-2 text-success font-weight-bold">Enrolling...</span>
        </div>
        <div class="mb-2">
            <input wire:click="privateUser" id="privateUser" class="form-check-input" type="checkbox" {{ $user->isPrivate ? 'checked' : '' }}>
            <label for="privateUser" class="ml-1 text-danger font-weight-bold">Make user Private</label>
            <span wire:loading wire:target="privateUser" class="small ml-2 text-danger font-weight-bold">Enrolling...</span>
        </div>
        <div>
            <input wire:click="verifyUser" id="verifyUser" class="form-check-input" type="checkbox" {{ $user->isVerified ? 'checked' : '' }}>
            <label for="verifyUser" class="ml-1 text-success font-weight-bold">Verify this user</label>
            <span wire:loading wire:target="verifyUser" class="small ml-2 text-success font-weight-bold">Verifying...</span>
        </div>
        @if (!$user->isStaff)
        <div class="mt-3">
            <button wire:click="masquerade" class="btn btn-sm btn-warning font-weight-bold">
                <i class="fas fa-theater-masks mr-1"></i>
                Masquerade
            </button>
            <span wire:loading wire:target="Masquerade" class="small ml-2 text-danger font-weight-bold">masquerading...</span>
        </div>
        @endif
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
        <div class="mt-2">
            <input wire:click="suspendUser" id="suspendUser" class="form-check-input" type="checkbox" {{ $user->isSuspended ? 'checked' : '' }}>
            <label for="suspendUser" class="ml-1 text-danger font-weight-bold">Suspend this user</label>
            <span wire:loading wire:target="suspendUser" class="small ml-2 text-danger font-weight-bold">Suspending...</span>
        </div>
        <div class="mt-3">
            <button wire:click="deleteTasks" class="btn btn-sm btn-danger font-weight-bold">
                <i class="fa fa-trash mr-1"></i>
                <i class="fa fa-check mr-1"></i>
                Delete all tasks
            </button>
            <span wire:loading wire:target="deleteTasks" class="small ml-2 text-danger font-weight-bold">Deleting...</span>
        </div>
        <div class="mt-2">
            <button wire:click="deleteComments" class="btn btn-sm btn-danger font-weight-bold">
                <i class="fa fa-trash mr-1"></i>
                <i class="fa fa-comment mr-1"></i>
                Delete all comments
            </button>
            <span wire:loading wire:target="deleteComments" class="small ml-2 text-danger font-weight-bold">Deleting...</span>
        </div>
        <div class="mt-2">
            <button wire:click="deleteQuestions" class="btn btn-sm btn-danger font-weight-bold">
                <i class="fa fa-trash mr-1"></i>
                <i class="fa fa-question-circle mr-1"></i>
                Delete all questions
            </button>
            <span wire:loading wire:target="deleteQuestions" class="small ml-2 text-danger font-weight-bold">Deleting...</span>
        </div>
        <div class="mt-2">
            <button wire:click="deleteAnswers" class="btn btn-sm btn-danger font-weight-bold">
                <i class="fa fa-trash mr-1"></i>
                <i class="fa fa-comments mr-1"></i>
                Delete all answers
            </button>
            <span wire:loading wire:target="deleteAnswers" class="small ml-2 text-danger font-weight-bold">Deleting...</span>
        </div>
        <div class="mt-2">
            <button wire:click="deleteProducts" class="btn btn-sm btn-danger font-weight-bold">
                <i class="fa fa-trash mr-1"></i>
                <i class="fa fa-box-open mr-1"></i>
                Delete all products
            </button>
            <span wire:loading wire:target="deleteProducts" class="small ml-2 text-danger font-weight-bold">Deleting...</span>
        </div>
        <div class="mt-2">
            <button wire:click="deleteUser" class="btn btn-sm btn-danger font-weight-bold">
                <i class="fa fa-trash mr-1"></i>
                <i class="fa fa-user mr-1"></i>
                Delete this user
            </button>
            <span wire:loading wire:target="deleteUser" class="small ml-2 text-danger font-weight-bold">Deleting...</span>
        </div>
        @endif
    </div>
</div>
