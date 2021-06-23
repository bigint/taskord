<span class="float-end">
    <div class="form-check">
        <input wire:click="onlyFollowingsTasks" class="form-check-input" type="checkbox" id="onlyFollowingsTasks"
            {{ auth()->user()->only_followings_tasks ? 'checked' : '' }}>
        <label class="form-check-label" for="onlyFollowingsTasks">
            Only following
        </label>
        <div wire:loading wire:target="onlyFollowingsTasks"
            class="spinner-border taskord-spinner spinner-border-sm ms-1"></div>
    </div>
</span>
