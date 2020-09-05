<div class="col-md-8">
    @include('components.alert')
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Profile</span>
            <div>Update your basic profile details.</div>
        </div>
        <div class="card-body">
            @if (session()->has('profile'))
                <div class="alert alert-success alert-dismissible fade show mb-3">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('profile') }}
                </div>
            @endif
            <form wire:submit.prevent="updateProfile">
                <div class="mb-3">
                    <label class="form-label">Firstname</label>
                    <input type="text" class="form-control @error('firstname') is-invalid @enderror" value="{{ $user->firstname }}" wire:model="firstname">
                    @error('firstname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Lastname</label>
                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" value="{{ $user->lastname }}" wire:model="lastname">
                    @error('lastname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Bio</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror"rows="3" wire:model="bio">{{ $user->bio }}</textarea>
                    @error('bio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" value="{{ $user->location }}" wire:model="location">
                    @error('location')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Company</label>
                    <input type="text" class="form-control @error('company') is-invalid @enderror" value="{{ $user->company }}" wire:model="company">
                    @error('company')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-file form-file-sm w-25">
                    <input type="file" wire:model="avatar" class="form-file-input">
                    <label class="form-file-label">
                        <span class="form-file-text">Choose file...</span>
                        <span class="form-file-button">Browse</span>
                    </label>
                </div>
                @error('avatar')
                <div class="text-danger font-weight-bold mt-3">{{ $message }}</div>
                @else
                @if ($avatar)
                <div class="h5 mt-3">Preview</div>
                <img class="avatar-100 rounded-circle" src="{{ $avatar->temporaryUrl() }}">
                @endif
                @enderror
                @if ($user->avatar)
                <div>
                    <img class="avatar-100 rounded-circle mt-3 mb-3" src="{{ $user->avatar }}" />
                </div>
                @endif
                <button type="submit" class="btn btn-primary">
                    Save
                    <span wire:target="updateProfile" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
                </button>
            </form>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Homepage</span>
            <div>Update your homepage preference.</div>
        </div>
        <div class="card-body">
            @if (session()->has('showfollowing'))
                <div class="alert alert-success alert-dismissible fade show mb-3">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('showfollowing') }}
                </div>
            @endif
            <input wire:click="onlyFollowingsTasks" id="onlyFollowingsTasks" class="form-check-input" type="checkbox" {{ $user->onlyFollowingsTasks ? 'checked' : '' }}>
            <label for="onlyFollowingsTasks" class="ml-1">Show only following user's tasks on homepage</label>
            <span wire:loading wire:target="onlyFollowingsTasks" class="small ml-2 text-success font-weight-bold">Updating...</span>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Social</span>
            <div>Update your social media links.</div>
        </div>
        <div class="card-body">
            @if (session()->has('social'))
                <div class="alert alert-success alert-dismissible fade show mb-3">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('social') }}
                </div>
            @endif
            <form wire:target="updateSocial" wire:submit.prevent="updateSocial">
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa fa-link"></i>
                    </span>
                    <input type="text" class="form-control @error('website') is-invalid @enderror" placeholder="Website" value="{{ $user->website }}" wire:model="website">
                    @error('website')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa fa-twitter"></i>
                    </span>
                    <input type="text" class="form-control @error('twitter') is-invalid @enderror" placeholder="Twitter" value="{{ $user->twitter }}" wire:model="twitter">
                    @error('twitter')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa fa-twitch"></i>
                    </span>
                    <input type="text" class="form-control @error('twitch') is-invalid @enderror" placeholder="Twitch" value="{{ $user->twitch }}" wire:model="twitch">
                    @error('twitch')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa fa-telegram"></i>
                    </span>
                    <input type="text" class="form-control @error('telegram') is-invalid @enderror" placeholder="Telegram" value="{{ $user->telegram }}" wire:model="telegram">
                    @error('telegram')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa fa-github"></i>
                    </span>
                    <input type="text" class="form-control @error('github') is-invalid @enderror" placeholder="GitHub" value="{{ $user->github }}" wire:model="github">
                    @error('github')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa fa-youtube"></i>
                    </span>
                    <input type="text" class="form-control @error('youtube') is-invalid @enderror" placeholder="YouTube" value="{{ $user->youtube }}" wire:model="youtube">
                    @error('youtube')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    Save
                    <span wire:target="updateSocial" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
                </button>
            </form>
        </div>
    </div>
</div>
