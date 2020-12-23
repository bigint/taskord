<span class="float-end">
    <input wire:click="onlyFollowingsTasks" id="onlyFollowingsTasks" class="form-check-input" type="checkbox" {{ Auth::user()->onlyFollowingsTasks ? 'checked' : '' }}>
    <label for="onlyFollowingsTasks" class="ms-1">
        Only following
    </label>
    <x-beta background="light" />
</span>
