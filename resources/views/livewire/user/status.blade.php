<div class="card mb-4">
    {{ $user->status_emoji }} {{ $user->status }}
    <div class="card-body">
        <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))">
            <div class="input-group">
                <button class="btn btn-outline-secondary trigger" type="button">{{ $user->status_emoji ? $user->status_emoji : '✅' }}</button>
                <input type="hidden" id="emoji_input" name="status_emoji" value="{{ $user->status_emoji ? $user->status_emoji : '✅' }}">
                <input type="text" class="form-control" name="status" value="{{ $user->status }}" placeholder="What's happening?">
            </div>

            <div class="d-flex justify-content-around pt-3">
                <button type="submit" class="btn btn-sm btn-danger text-white me-1 w-100">
                    Clear Status
                </button>
                <button type="submit" class="btn btn-sm btn-success text-white ms-1 w-100">
                    Set Status
                </button>
            </div>
        </form>
    </div>
</div>
