<div class="col-md-8">
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Account</span>
            <div>Change your username and email.</div>
        </div>
        <div class="card-body">
            @include('components.alert')
            <form wire:submit.prevent="updateAccount">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ $user->username }}" wire:model="username">
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}" wire:model="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    Save
                    <span wire:target="updateAccount" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
                </button>
            </form>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Beta</span>
            <div>
                Get release earlier.
                <x-beta background="light"/>
            </div>
        </div>
        <div class="card-body">
            @if (session()->has('isBeta'))
                <div class="alert alert-success alert-dismissible fade show mb-3">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('isBeta') }}
                </div>
            @endif
            <input wire:click="enrollBeta" id="enrollBeta" class="form-check-input" type="checkbox" {{ $user->isBeta ? 'checked' : '' }}>
            <label for="enrollBeta" class="ml-1">Enroll to Beta</label>
            <span wire:loading wire:target="enrollBeta" class="small ml-2 text-success font-weight-bold">Enrolling...</span>
        </div>
    </div>
    <div class="card">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Private Tasks</span>
            <div>
                All your tasks will hidden from public.
                <x-beta background="light"/>
            </div>
        </div>
        <div class="card-body">
            @if (session()->has('isPrivate'))
                <div class="alert alert-success alert-dismissible fade show mb-3">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('isPrivate') }}
                </div>
            @endif
            @if ($user->isPatron)
            <input wire:click="enrollPrivate" id="enrollPrivate" class="form-check-input" type="checkbox" {{ $user->isPrivate ? 'checked' : '' }}>
            <label for="enrollPrivate" class="ml-1">Hide all tasks from public</label>
            <span wire:loading wire:target="enrollPrivate" class="small ml-2 text-success font-weight-bold">Enrolling...</span>
            @else
            <a class="btn btn-success text-white" href={{ route('patron.home') }}>
                Support Taskord
            </a>
            @endif
        </div>
    </div>
</div>
