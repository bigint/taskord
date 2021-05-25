<span wire:init="loadModerator">
    <div class="text-uppercase fw-bold text-secondary pb-2">
        <x-heroicon-o-shield-check class="heroicon text-danger" />
        <span class="text-danger">Moderator</span>
    </div>
    <div class="card border-danger mb-4">
        <div class="card-body">
            @if (!$ready_to_load)
                <div class="card-body text-center">
                    <div class="spinner-border spinner-border-sm taskord-spinner text-secondary" role="status"></div>
                </div>
            @else
                <div class="mb-1">
                    <x-heroicon-o-clock class="heroicon text-secondary" />
                    <span class="h6">Last Active:</span>
                    <span class="fw-bold">
                        @if ($user->last_active)
                            @if (strtotime(carbon()) - strtotime($user->last_active) <= 5)
                                <span class="fw-bold text-success">active</span>
                            @else
                                {{ carbon($user->last_active)->diffForHumans() }}
                            @endif
                        @else
                            <span class="small fw-bold text-secondary">Not Set</span>
                        @endif
                    </span>
                </div>
                <div class="mb-1 overflow-hidden">
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
                    @if ($user->last_ip)
                        <a class="fw-bold" href="https://ipinfo.io/{{ $user->last_ip }}" target="_blank" rel="noreferrer">
                            {{ Str::limit($user->last_ip, 15, '..') }}
                        </a>
                    @else
                        <span class="fw-bold text-secondary">
                            Not set
                        </span>
                    @endif
                    @php
                        $suspectedUsers = \App\Models\User::where('last_ip', $user->last_ip)->get();
                    @endphp
                    @if ($suspectedUsers->count() > 1)
                        <div class="small mt-1">
                            <x-heroicon-o-exclamation class="heroicon me-1 text-danger" />
                            <span class="fw-bold">{{ $suspectedUsers->count() }}</span>  {{ $suspectedUsers->count() < 1 ? 'user' : 'users' }} associated with the same IP
                            <details class="mt-1">
                                <summary>See all associated users</summary>
                                <ul class="mb-2">
                                    @foreach ($suspectedUsers as $suspectedUser)
                                        <li>
                                            <a
                                                class="user-popover"
                                                data-id="{{ $suspectedUser->id }}"
                                                href="{{ route('user.done', ['username' => $suspectedUser->username]) }}"
                                            >
                                                {{ '@'.$suspectedUser->username }}
                                            </a>
                                        </li>
                                    @endforeach
                                <ul>
                            </details>
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
                            $hour = carbon()->setTimezone($user->timezone)->format('H');
                            $formattedTZ = str_replace("_", " ", $user->timezone)
                            @endphp
                            {{ $formattedTZ }}
                            •
                            <span class="text-secondary">
                                {{
                                    carbon()
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
                    <x-heroicon-o-flag class="heroicon heroicon-20px" />
                    Flags
                </div>
                <div class="mb-2 mt-3">
                    <input wire:click="enrollBeta" id="enrollBeta" class="form-check-input" type="checkbox" wire:model="is_beta">
                    <label for="enrollBeta" class="ms-1">Enroll to Beta</label >
                </div>
                <div class="mb-2">
                    <input wire:click="enrollStaff" id="enrollStaff" class="form-check-input" type="checkbox" wire:model="is_staff">
                    <label for="enrollStaff" class="ms-1">Enroll to Staff</label>
                </div>
                <div class="mb-2">
                    <input wire:click="enrollPatron" id="enrollPatron" class="form-check-input" type="checkbox" wire:model="is_patron">
                    <label for="enrollPatron" class="ms-1">Enroll to Patron</label>
                </div>
                <div class="mb-2">
                    <input wire:click="enrollDarkMode" id="enrollDarkMode" class="form-check-input" type="checkbox" wire:model="dark_mode">
                    <label for="enrollDarkMode" class="ms-1">Enable Dark Mode</label>
                </div>
                <div class="mb-2">
                    <input wire:click="enrollDeveloper" id="enrollDeveloper" class="form-check-input" type="checkbox" wire:model="is_contributor">
                    <label for="enrollDeveloper" class="ms-1">Enroll to Contributor</label>
                </div>
                <div class="mb-2">
                    <input wire:click="privateUser" id="privateUser" class="form-check-input" type="checkbox" wire:model="is_private">
                    <label for="privateUser" class="ms-1 text-danger fw-bold">Make user Private</label>
                </div>
                <div>
                    <input wire:click="verifyUser" id="verifyUser" class="form-check-input" type="checkbox" wire:model="is_verified">
                    <label for="verifyUser" class="ms-1 text-success fw-bold">Verify this user</label>
                </div>
                @if (!$user->is_staff)
                    <div class="mt-3">
                        <button wire:loading.attr="disabled" wire:click="masquerade" class="btn btn-sm btn-warning fw-bold">
                            <x-heroicon-o-eye class="heroicon" />
                            Masquerade
                        </button>
                    </div>
                        <div class="text-info h5 mt-3">
                        <x-heroicon-o-pencil-alt class="heroicon heroicon-20px" />
                        {{__("Notes")}}
                            <form wire:submit.prevent="updateUserStaffNotes">
                                <textarea name="staff_notes" id="staff_notes" class="form-control mt-3" rows="3" wire:model="staff_notes" placeholder="Important information about this user..">
                                </textarea>
                                <button wire:click="updateUserStaffNotes" type="button" class="btn btn-sm btn-primary mt-2">
                                    <x-heroicon-o-save class="heroicon" />
                                    Save Notes
                                </button>
                            </form>
                    </div>
                @endif
                @if (!$user->is_staff)
                    <hr>
                    <div class="text-danger h5 mb-3">
                        <x-heroicon-o-user class="heroicon heroicon-20px" />
                        Danger Zone
                    </div>
                    <div class="mt-2">
                        <input wire:click="flagUser" id="flagUser" class="form-check-input" type="checkbox" wire:model="spammy">
                        <label for="flagUser" class="ms-1 text-danger fw-bold">Flag this user</label>
                    </div>
                    <div class="mt-2">
                        <input wire:click="suspendUser" id="suspendUser" class="form-check-input" type="checkbox" wire:model="is_suspended">
                        <label for="suspendUser" class="ms-1 text-danger fw-bold">Suspend this user</label>
                    </div>
                    <div class="mt-3">
                        <button wire:loading.attr="disabled" wire:click="resetAvatar" class="btn btn-sm btn-danger fw-bold">
                            <x-heroicon-o-refresh class="heroicon" />
                            Reset avatar
                        </button>
                    </div>
                    <div class="mt-2">
                        <button wire:loading.attr="disabled" wire:click="releaseUsername" class="btn btn-sm btn-danger fw-bold">
                            <x-heroicon-o-switch-horizontal class="heroicon" />
                            Release username
                        </button>
                    </div>
                    <div class="mt-2">
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
                        <button wire:loading.attr="disabled" wire:click="deleteMilestones" class="btn btn-sm btn-danger fw-bold">
                            <x-heroicon-o-trash class="heroicon" />
                            <x-heroicon-o-truck class="heroicon" />
                            Delete all milestones
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
            @endif
        </div>
    </div>
</span>
