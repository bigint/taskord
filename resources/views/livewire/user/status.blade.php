<div class="card mb-4" id="status-card">
    <div class="card-body">
        <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))">
            <div class="input-group">
                <button class="bg-transparent border px-2 rounded-start trigger"
                    type="button">{{ $user->status_emoji ? $user->status_emoji : '💭' }}</button>
                <input type="hidden" id="emoji_input" name="status_emoji"
                    value="{{ $user->status_emoji ? $user->status_emoji : '💭' }}">
                <input type="text" class="form-control border" name="status" value="{{ $user->status }}"
                    placeholder="What's happening?">
            </div>

            <div class="d-flex justify-content-around pt-3">
                @if ($user->status)
                    <button type="button" wire:loading.attr="disabled" wire:click="clearStatus"
                        class="btn btn-sm btn-outline-danger rounded-pill float-end w-100 me-1">
                        Clear Status
                    </button>
                @endif
                <button type="submit" class="btn btn-sm btn-outline-success rounded-pill float-end w-100 ms-1">
                    Set Status
                </button>
            </div>
        </form>
    </div>
</div>
