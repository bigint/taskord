<span>
    <div class="text-uppercase fw-bold text-secondary pb-2">
        <x-heroicon-o-shield-check class="heroicon text-danger" />
        <span class="text-danger">Moderator</span>
    </div>
    <div class="card border-danger mb-4">
        <div class="card-body">
            <div class="mb-1">
                <x-heroicon-o-clock class="heroicon text-secondary" />
                <span class="h6">Last Active:</span>
                <span class="fw-bold">
                    @if ($user->last_active)
                    @if (strtotime(Carbon::now()) - strtotime($user->last_active) <= 5)
                    <span class="fw-bold text-success">active</span>
                    @else
                    {{ Carbon::parse($user->last_active)->diffForHumans() }}
                    @endif
                    @else
                    <span class="small fw-bold text-secondary">Not Set</span>
                    @endif
                </span>
            </div>
            <div class="mb-1">
                <x-heroicon-o-mail class="heroicon text-secondary" />
                <span class="h6">User Email:</span>
                <a class="fw-bold" href="mailto:{{ $user->email }}">
                    {{ $user->email }}
                </a>
                @if ($user->hasVerifiedEmail())
                <x-heroicon-o-check class="heroicon text-success" />
                @else
                <x-heroicon-o-x class="heroicon text-danger" />
                @endif
            </div>
            <div class="mb-1">
                <span class="h6">
                    <x-heroicon-o-credit-card class="heroicon text-secondary" />
                    Last login IP:
                </span>
                @if ($user->lastIP)
                <a class="fw-bold" href="https://ipinfo.io/{{ $user->lastIP }}" target="_blank" rel="noreferrer">
                    {{ $user->lastIP }}
                </a>
                @else
                <span class="fw-bold text-secondary">
                    Not set
                </span>
                @endif
                @php
                    if ($user->lastIP) {
                        $usersCount = \App\Models\User::where('lastIP', $user->lastIP)->count('id');
                    } else {
                        $usersCount = 0;
                    }
                @endphp
                @if ($usersCount > 1)
                <div class="small mt-1">
                    <x-heroicon-o-exclamation class="heroicon text-danger" />
                    <span class="fw-bold">{{ $usersCount }}</span>  {{ $usersCount < 1 ? 'user' : 'users' }} associated with the same IP
                </div>
                @endif
            </div>
            <div class="mb-3">
                <span class="h6">
                    <x-heroicon-o-clock class="heroicon text-secondary" />
                    Timezone:
                </span>
                @if ($user->timezone)
                <span class="fw-bold">
                    @php
                    $hour = Carbon::now()->setTimezone($user->timezone)->format('H');
                    $formattedTZ = str_replace("_", " ", $user->timezone)
                    @endphp
                    {{ $formattedTZ }}
                    •
                    <span class="text-secondary">
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
                <span class="fw-bold text-secondary">
                    Not set
                </span>
                @endif
            </div>
            <div class="text-info h5 mb-3">
                <x-heroicon-o-flag class="heroicon-2x" />
                Flags
            </div>
            <div class="mb-2 mt-3">
                <input wire:click="enrollBeta" id="enrollBeta" class="form-check-input" type="checkbox" {{ $user->isBeta ? 'checked' : '' }}>
                <label for="enrollBeta" class="ms-1">Enroll to Beta</label >
            </div>
            <div class="mb-2">
                <input wire:click="enrollStaff" id="enrollStaff" class="form-check-input" type="checkbox" {{ $user->isStaff ? 'checked' : '' }}>
                <label for="enrollStaff" class="ms-1">Enroll to Staff</label>
            </div>
            <div class="mb-2">
                <input wire:click="enrollPatron" id="enrollPatron" class="form-check-input" type="checkbox" {{ $user->isPatron ? 'checked' : '' }}>
                <label for="enrollPatron" class="ms-1">Enroll to Patron</label>
            </div>
            <div class="mb-2">
                <input wire:click="enrollDarkMode" id="enrollDarkMode" class="form-check-input" type="checkbox" {{ $user->darkMode ? 'checked' : '' }}>
                <label for="enrollDarkMode" class="ms-1">Enable Dark Mode</label>
            </div>
            <div class="mb-2">
                <input wire:click="enrollDeveloper" id="enrollDeveloper" class="form-check-input" type="checkbox" {{ $user->isDeveloper ? 'checked' : '' }}>
                <label for="enrollDeveloper" class="ms-1">Enroll to Contributor</label>
            </div>
            <div class="mb-2">
                <input wire:click="privateUser" id="privateUser" class="form-check-input" type="checkbox" {{ $user->isPrivate ? 'checked' : '' }}>
                <label for="privateUser" class="ms-1 text-danger fw-bold">Make user Private</label>
            </div>
            <div>
                <input wire:click="verifyUser" id="verifyUser" class="form-check-input" type="checkbox" {{ $user->isVerified ? 'checked' : '' }}>
                <label for="verifyUser" class="ms-1 text-success fw-bold">Verify this user</label>
            </div>
            @if (!$user->isStaff)
            <div class="mt-3">
                <button wire:loading.attr="disabled" wire:click="masquerade" class="btn btn-sm btn-warning fw-bold">
                    <x-heroicon-o-eye class="heroicon" />
                    Masquerade
                </button>
            </div>
            @endif
            @if (!$user->isStaff)
            <hr>
            <div class="text-danger h5 mb-3">
                <x-heroicon-o-user class="heroicon-2x" />
                Danger Zone
            </div>
            <div class="mt-2">
                <input wire:click="flagUser" id="flagUser" class="form-check-input" type="checkbox" {{ $user->isFlagged ? 'checked' : '' }}>
                <label for="flagUser" class="ms-1 text-danger fw-bold">Flag this user</label>
            </div>
            <div class="mt-2">
                <input wire:click="suspendUser" id="suspendUser" class="form-check-input" type="checkbox" {{ $user->isSuspended ? 'checked' : '' }}>
                <label for="suspendUser" class="ms-1 text-danger fw-bold">Suspend this user</label>
            </div>
            <div class="mt-2">
                <button wire:loading.attr="disabled" wire:click="resetAvatar" class="btn btn-sm btn-danger fw-bold">
                    <x-heroicon-o-refresh class="heroicon" />
                    Reset avatar
                </button>
            </div>
            <div class="mt-3">
                <button wire:loading.attr="disabled" wire:click="deleteTasks" class="btn btn-sm btn-danger fw-bold">
                    <x-heroicon-o-trash class="heroicon" />
                    <x-heroicon-o-check class="heroicon" />
                    Delete all tasks
                </button>
            </div>
            <div class="mt-2">
                <button wire:loading.attr="disabled" wire:click="deleteComments" class="btn btn-sm btn-danger fw-bold">
                    <x-heroicon-o-trash class="heroicon" />
                    <x-heroicon-o-chat-alt class="heroicon" />
                    Delete all comments
                </button>
            </div>
            <div class="mt-2">
                <button wire:loading.attr="disabled" wire:click="deleteQuestions" class="btn btn-sm btn-danger fw-bold">
                    <x-heroicon-o-trash class="heroicon" />
                    <x-heroicon-o-question-mark-circle class="heroicon" />
                    Delete all questions
                </button>
            </div>
            <div class="mt-2">
                <button wire:loading.attr="disabled" wire:click="deleteAnswers" class="btn btn-sm btn-danger fw-bold">
                    <x-heroicon-o-trash class="heroicon" />
                    <x-heroicon-o-chat-alt-2 class="heroicon" />
                    Delete all answers
                </button>
            </div>
            <div class="mt-2">
                <button wire:loading.attr="disabled" wire:click="deleteProducts" class="btn btn-sm btn-danger fw-bold">
                    <x-heroicon-o-trash class="heroicon" />
                    <x-heroicon-o-cube class="heroicon" />
                    Delete all products
                </button>
            </div>
            <div class="mt-2">
                <button wire:loading.attr="disabled" wire:click="deleteUser" class="btn btn-sm btn-danger fw-bold">
                    <x-heroicon-o-trash class="heroicon" />
                    <x-heroicon-o-user class="heroicon" />
                    Delete this user
                </button>
            </div>
            @endif
        </div>
    </div>
</span>
