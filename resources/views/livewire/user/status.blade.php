<div class="card mb-4">
    <div class="card-body">
        <x-alert />
        <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))">
            <div class="input-group">
                <button class="btn btn-outline-secondary trigger" type="button">{{ $user->status_emoji ? $user->status_emoji : '✅' }}</button>
                <input type="hidden" id="emoji_input" name="status_emoji" value="{{ $user->status_emoji ? $user->status_emoji : '✅' }}">
                <input type="text" class="form-control" name="status" value="{{ $user->status }}" placeholder="What's happening?">
            </div>

            <div class="justify-content-around pt-3">
                <button type="submit" class="btn btn-sm btn-success text-white float-end">
                    Set Status
                    <span wire:target="submit" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
                </button>
            </div>
        </form>
    </div>
</div>
