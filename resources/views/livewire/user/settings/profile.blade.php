<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3">
            <span class="h5">Profile</span>
            <div>Update your basic profile details.</div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="updateProfile">
                <div class="mb-3">
                    <label class="form-label">Firstname</label>
                    <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                        value="{{ $user->firstname }}" wire:model.defer="firstname">
                    @error('firstname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Lastname</label>
                    <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                        value="{{ $user->lastname }}" wire:model.defer="lastname">
                    @error('lastname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Bio</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" rows="3"
                        wire:model.defer="bio">{{ $user->bio }}</textarea>
                    @error('bio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                        value="{{ $user->location }}" wire:model.defer="location">
                    @error('location')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Company</label>
                    <input type="text" class="form-control @error('company') is-invalid @enderror"
                        value="{{ $user->company }}" wire:model.defer="company">
                    @error('company')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Avatar</label>
                    <div class="form-file w-25">
                        <input class="form-control form-control-sm" wire:model="avatar" type="file">
                        <button wire:loading.attr="disabled" wire:click="useGravatar"
                            class="btn btn-outline-success rounded-pill mt-3">
                            Use Gravatar
                        </button>
                        <button wire:loading.attr="disabled" wire:click="resetAvatar"
                            class="btn btn-outline-danger rounded-pill mt-3">
                            Reset
                        </button>
                    </div>
                </div>
                <div wire:loading wire:target="avatar">
                    <div class="spinner-border spinner-border-sm" role="status"></div>
                </div>
                @error('avatar')
                    <div class="text-danger fw-bold mt-3">{{ $message }}</div>
                @else
                    @if ($avatar)
                        <div>
                            <img loading=lazy class="avatar-100 rounded-circle mt-2 mb-3"
                                src="{{ $avatar->temporaryUrl() }}" height="100" width="100" />
                        </div>
                    @else
                        @if ($user->avatar)
                            <div>
                                <img loading=lazy class="avatar-100 rounded-circle mt-2 mb-3"
                                    src="{{ Helper::getCDNImage($user->avatar, 240) }}" height="100" width="100"
                                    alt="{{ $user->username }}'s avatar" />
                            </div>
                        @endif
                    @endif
                @enderror
                <button type="submit" class="btn btn-outline-primary rounded-pill">
                    Save
                </button>
            </form>
        </div>
    </div>
    <div class="card mb-4" id="goal">
        <div class="card-header py-3">
            <span class="h5">Goal</span>
            <div>Complete your goal and earn additional reputations</div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="updateGoal">
                <div>
                    <div class="form-check">
                        <input wire:click="enableGoal" id="enableGoal" class="form-check-input" type="checkbox"
                            wire:model="hasGoal">
                        <label for="enableGoal" class="form-check-label">Enable Goal</label>
                    </div>
                </div>
                @if ($hasGoal)
                    <div class="mt-2 mb-3">
                        <label class="form-label mt-2">Number of tasks</label>
                        <input type="text" class="form-control @error('dailyGoal') is-invalid @enderror"
                            value="{{ $user->daily_goal }}" wire:model.defer="dailyGoal">
                        @error('dailyGoal')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-outline-primary rounded-pill">
                        Set Goal
                    </button>
                @endif
            </form>
        </div>
    </div>
    <div class="card mb-4" id="vacation">
        <div class="card-header py-3">
            <span class="h5">Vacation mode</span>
            <div>
                When turned on, your streaks will remain intact even if you don't create a task.
                <x:labels.beta />
            </div>
        </div>
        <div class="card-body">
            <div class="form-check">
                <input wire:click="toggleVacationMode" id="toggleVacationMode" class="form-check-input" type="checkbox"
                    {{ $user->vacation_mode ? 'checked' : '' }}>
                <label for="toggleVacationMode" class="form-check-label">Enable vacation mode</label>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header py-3">
            <span class="h5">Homepage</span>
            <div>Update your homepage preference.</div>
        </div>
        <div class="card-body">
            <div class="form-check">
                <input wire:click="onlyFollowingsTasks" id="onlyFollowingsTasks" class="form-check-input"
                    type="checkbox" {{ $user->only_followings_tasks ? 'checked' : '' }}>
                <label for="onlyFollowingsTasks" class="form-check-label">Show only following user's tasks on
                    homepage</label>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header py-3">
            <span class="h5">Sponsor</span>
            <div>Add Sponsor URL to show badge in your profile.</div>
        </div>
        <div class="card-body">
            <form wire:target="updateSponsor" wire:submit.prevent="updateSponsor">
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <x-heroicon-o-heart class="heroicon text-danger" />
                    </span>
                    <input type="text" class="form-control @error('sponsor') is-invalid @enderror"
                        placeholder="Sponsor URL" value="{{ $user->sponsor }}" wire:model.defer="sponsor">
                    @error('sponsor')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-outline-primary rounded-pill">
                    Save
                </button>
            </form>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header py-3">
            <span class="h5">Social</span>
            <div>Update your social media links.</div>
        </div>
        <div class="card-body">
            <form wire:target="updateSocial" wire:submit.prevent="updateSocial">
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <x-heroicon-o-link class="heroicon" />
                    </span>
                    <input type="text" class="form-control @error('website') is-invalid @enderror" placeholder="Website"
                        value="{{ $user->website }}" wire:model.defer="website">
                    @error('website')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <img src="https://ik.imagekit.io/taskordimg/icons/twitter_4cXueyhRfH.svg" height="15" width="15"
                            loading=lazy />
                    </span>
                    <input type="text" class="form-control @error('twitter') is-invalid @enderror" placeholder="Twitter"
                        value="{{ $user->twitter }}" wire:model.defer="twitter">
                    @error('twitter')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <img src="https://ik.imagekit.io/taskordimg/icons/twitch_ZzpKWQt7T.svg" height="15" width="15"
                            loading=lazy />
                    </span>
                    <input type="text" class="form-control @error('twitch') is-invalid @enderror" placeholder="Twitch"
                        value="{{ $user->twitch }}" wire:model.defer="twitch">
                    @error('twitch')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <img src="https://ik.imagekit.io/taskordimg/icons/telegram_4ea__J3dwB.svg" height="15"
                            width="15" loading=lazy />
                    </span>
                    <input type="text" class="form-control @error('telegram') is-invalid @enderror"
                        placeholder="Telegram" value="{{ $user->telegram }}" wire:model.defer="telegram">
                    @error('telegram')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <img class="github-logo" src="https://ik.imagekit.io/taskordimg/icons/github_9E8bhMFJtH.svg"
                            height="15" width="15" loading=lazy />
                    </span>
                    <input type="text" class="form-control @error('github') is-invalid @enderror" placeholder="GitHub"
                        value="{{ $user->github }}" wire:model.defer="github">
                    @error('github')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <img src="https://ik.imagekit.io/taskordimg/icons/youtube_qUsz_87ogn.svg" height="15" width="15"
                            loading=lazy />
                    </span>
                    <input type="text" class="form-control @error('youtube') is-invalid @enderror" placeholder="YouTube"
                        value="{{ $user->youtube }}" wire:model.defer="youtube">
                    @error('youtube')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-outline-primary rounded-pill">
                    Save
                </button>
            </form>
        </div>
    </div>
</div>
