<span class="float-end">
    <input wire:click="onlyFollowingsTasks" id="onlyFollowingsTasks" class="form-check-input" type="checkbox" {{ Auth::user()->onlyFollowingsTasks ? 'checked' : '' }}>
    <label for="onlyFollowingsTasks" class="ms-1">
        Only following
    </label>
    <span wire:loading wire:target="onlyFollowingsTasks" class="small ms-2 spinner-border spinner-border-sm text-primary"></span>
    <x-beta background="light" />
</span>
